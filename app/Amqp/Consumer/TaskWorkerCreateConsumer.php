<?php

declare(strict_types=1);

namespace App\Amqp\Consumer;

use App\Amqp\Producer\TaskOrderUpdateProducer;
use App\Amqp\Producer\TaskWorkerCreateProducer;
use App\Amqp\Producer\TaskWorkerResultHookProducer;
use App\Exception\BusinessException;
use App\Factory\TaskWorkerFactory;
use App\Model\QueueFailedMessage;
use App\Model\TaskWorker;
use App\Service\RedisService;
use App\Service\SystemSettingService;
use App\Service\TaskTypeService;
use Carbon\Carbon;
use GuzzleHttp\Exception\GuzzleException;
use Hyperf\Amqp\Producer;
use Hyperf\Amqp\Result;
use Hyperf\Amqp\Annotation\Consumer;
use Hyperf\Amqp\Message\ConsumerMessage;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Guzzle\ClientFactory;
use Hyperf\Redis\Redis;
use PhpAmqpLib\Message\AMQPMessage;
use Psr\Log\LoggerInterface;
use Ramsey\Uuid\Uuid;

#[Consumer(exchange: 'task_worker_create', routingKey: 'task_worker_create', queue: 'task_worker_create_queue', name: "TaskWorkerCreatedConsumer", nums: 1)]
class TaskWorkerCreateConsumer extends ConsumerMessage
{
    #[Inject]
    protected Producer $producer;

    #[Inject]
    protected LoggerInterface $logger;

    #[Inject]
    protected Redis $redis;

    #[Inject]
    protected TaskTypeService $taskTypeService;

    #[Inject]
    protected SystemSettingService $systemSettingService;

    public function consumeMessage($data, AMQPMessage $message): Result
    {
        // 获取会员ID
        $member_id      = $data['member_id'];
        // 获取订单号
        $order_no       = $data['order_no'];
        // 获取平台
        $platform       = $data['platform'];
        // 获取任务类型
        $task_type      = $data['task_type'];
        // 定义当前时间
        $current_time = Carbon::now();

        try {
            // 默认 30~60 秒
            $expired_seconds = mt_rand(30, 60);

            // 获取配置
            $taskWorkerSecond = trim((string) $this->systemSettingService->getSettingByKey('task_worker_second'));

            if ($taskWorkerSecond !== '') {
                // 固定秒数，例如：30
                if (is_numeric($taskWorkerSecond)) {
                    $expired_seconds = max(1, (int) $taskWorkerSecond);
                } elseif (str_contains($taskWorkerSecond, ',')) {
                    $arr = array_map('trim', explode(',', $taskWorkerSecond));
                    if (count($arr) === 2 && is_numeric($arr[0]) && is_numeric($arr[1])) {
                        $min = (int) $arr[0];
                        $max = (int) $arr[1];
                        if ($min > 0 && $max >= $min) {
                            $expired_seconds = mt_rand($min, $max);
                        }
                    }
                }
            }

            // 随机生成任务类型
            $random_task_type = $this->random_task_type($member_id, $task_type);

            // 生成图片ID
            $image_id = Uuid::uuid4()->toString();

            // 查询任务类型
            $task_type_info = $this->taskTypeService->getTaskTypeByCode($random_task_type);

            // 获取任务工作验证码信息
            $captcha_result = TaskWorkerFactory::create($random_task_type)->create($image_id, $order_no);

            // 生成订单数据
            $task_worker = new TaskWorker();
            $task_worker->member_id = $member_id;
            $task_worker->task_type_id = $task_type_info->id;
            $task_worker->order_no = $order_no;
            $task_worker->amount = $task_type_info->worker_price;
            $task_worker->payload = json_encode($captcha_result['payload']);
            $task_worker->answer = $captcha_result['result'];
            $task_worker->expired_at = $current_time->copy()->addSeconds($expired_seconds)->toDateTimeString();
            if (!$task_worker->save()) {
                throw new BusinessException("Order saving failed");
            }

            // 写入订单缓存
            $this->redis->pipeline(function ($pipe) use ($task_worker) {
                // 剩余时间，单位秒
                $remaining_time = strtotime($task_worker->expired_at) - time();
                // 更新任务订单标记
                $pipe->setex("task_worker_mark:{$task_worker->member_id}", $remaining_time, $task_worker->order_no);
                // 更新任务订单状态
                $pipe->setex("task_worker_status:{$task_worker->order_no}", $remaining_time, 2);
                // 设置任务订单信息
                $pipe->setex("task_worker_info:{$task_worker->order_no}", $remaining_time + 10, $task_worker->toJson(256));
                // 任务过期
                $pipe->zadd('task_worker_expire', strtotime($task_worker->expired_at), $task_worker->order_no);
            });

            // 获取Worker订单更新生产者
            $task_order_update_producer = new TaskOrderUpdateProducer(['order_no' => $task_worker->order_no, 'status' => 2]);
            // 发送Worker订单更新队列
            $send_task_order_update_producer = $this->producer->produce($task_order_update_producer);
            if (!$send_task_order_update_producer) {
                throw new BusinessException("TaskOrderUpdateProducer send failed");
            }

            // 获取Webhook生产者
            $task_worker_result_hook_producer = new TaskWorkerResultHookProducer(['platform' => "verifyworker", 'task_type' => $task_type_info->code, 'order_no' => $task_worker->order_no, 'result' => $task_worker->answer]);
            // 发送队列
            $send_task_worker_result_hook_producer = $this->producer->produce($task_worker_result_hook_producer);
            if (!$send_task_worker_result_hook_producer) {
                throw new BusinessException("TaskWorkerResultHookProducer send failed");
            }

            return Result::ACK;
        } catch (\Throwable $e) {
            $this->logger->error('TaskWorkerCreateConsumerException:' . $e->getMessage());
            // 步进消费次数
            $data['retry'] = $data['retry'] ?? 1;

            if ($data['retry'] >= 3) {
                $queue_failed_message = new QueueFailedMessage();
                $queue_failed_message->queue_name = $this->getQueue();
                $queue_failed_message->message_body = json_encode($data);
                $queue_failed_message->retry_count  = $data['retry'];
                $queue_failed_message->error_message  = $e->getMessage();
                if (!$queue_failed_message->save()){
                    $this->logger->error('TaskWorkerCreateConsumerException,Retry limit reached, write failed.');
                }

                // 定义任务订单标记缓存键
                $task_worker_order_mark_cache_key = "task_worker_order_mark:{$member_id}";
                // 定义任务订单状态缓存键
                $task_worker_order_status_cache_key = "task_worker_order_status:{$order_no}";
                // 删除Redis缓存
                $this->redis->del($task_worker_order_mark_cache_key,$task_worker_order_status_cache_key);
                // 完成队列
                return Result::ACK;
            }
            $data['retry']++;
            // 获取任务worker创建生产者
            $task_worker_create_producer = new TaskWorkerCreateProducer($data);
            // 发送到队列，无需序列化，直接发送数组
            $this->producer->produce($task_worker_create_producer);

            return Result::ACK;
        }
    }

    /**
     * 随机生成一个任务类型
     * @param int $member_id
     * @param string $task_type 任务类型
     * @return string 验证码类型
     */
    protected function random_task_type(int $member_id, string $task_type) :string
    {
        // 生成一个随机数
        $random_number = mt_rand(1,100);

        $weights = match ($task_type) {
            'all' => [
                'image_text'  => 30,
                'image_math'  => 60,
                'image_click' => 90,
                'turnstile'   => 100,
            ],
            'simple' => [
                'image_text' => 45,
                'image_math' => 90,
                'turnstile'  => 100
            ],
            'high' => [
                'image_click' => 80,
                'turnstile'   => 100
            ],
        };

        $weight = '';

        foreach ($weights as $key => $value) {
            if ($random_number <= $value) {
                $weight =  $key;
                break;
            }
        }

        return $weight;
    }
}
