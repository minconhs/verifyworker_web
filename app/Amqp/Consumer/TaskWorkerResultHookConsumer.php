<?php

declare(strict_types=1);

namespace App\Amqp\Consumer;

use App\Amqp\Producer\TaskWorkerResultHookProducer;
use App\Exception\BusinessException;
use App\Model\QueueFailedMessage;
use App\Service\SystemSettingService;
use GuzzleHttp\Exception\GuzzleException;
use Hyperf\Amqp\Producer;
use Hyperf\Amqp\Result;
use Hyperf\Amqp\Annotation\Consumer;
use Hyperf\Amqp\Message\ConsumerMessage;
use Hyperf\DbConnection\Db;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Guzzle\ClientFactory;
use Hyperf\Redis\Redis;
use PhpAmqpLib\Message\AMQPMessage;
use Psr\Log\LoggerInterface;

#[Consumer(exchange: 'task_worker_result_hook', routingKey: 'task_worker_result_hook', queue: 'task_worker_result_hook_queue', name: "TaskWorkerResultHookConsumer", nums: 1)]
class TaskWorkerResultHookConsumer extends ConsumerMessage
{
    #[Inject]
    protected ClientFactory $clientFactory;

    #[Inject]
    protected Producer $producer;

    #[Inject]
    protected LoggerInterface $logger;

    #[Inject]
    protected Redis $redis;

    #[Inject]
    protected SystemSettingService $systemSettingService;

    public function consumeMessage($data, AMQPMessage $message): Result
    {
        // 获取平台
        $platform       = $data['platform'];
        // 获取类型
        $task_type      = $data['task_type'];
        // 获取订单号
        $order_no       = $data['order_no'];
        // 获取结果
        $result         = $data['result'];

        // 获取WebHook
        $task_worker_result_hook = $this->systemSettingService->getSettingByKey('task_worker_result_hook');
        if (empty($task_worker_result_hook)) {
            return Result::ACK;
        }

        // 如果是图片点击任务,需要特殊处理
        if ($task_type == 'image_click') {
            $result_temp = json_decode($result,true);
            $handler_result = [];
            foreach ($result_temp as $item) {
                [$x1,$y1,$x2,$y2] = $item;
                $handler_result[] = [
                    'x' => ($x2 - $x1) / 2 + $x1,
                    'y' => ($y2 - $y1) / 2 + $y1
                ];
            }
            $result = json_encode($handler_result);
        }


        $options = ['timeout' => 10, 'connect_timeout' => 5];

        $client = $this->clientFactory->create($options);

        try {
            $client->post($task_worker_result_hook, [
                'form_params' => [
                    'platform' => $platform,
                    'order_no' => $order_no,
                    'result' => $result
                ],
            ]);
            // 完成消费
            return Result::ACK;
        } catch (\Throwable $e) {
            Db::rollBack();
            $this->logger->error('TaskWorkerResultHookConsumerException:' . $e->getMessage());
            // 步进消费次数
            $data['retry'] = $data['retry'] ?? 1;;

            if ($data['retry'] >= 3) {
                $queue_failed_message = new QueueFailedMessage();
                $queue_failed_message->queue_name = $this->getQueue();
                $queue_failed_message->message_body = json_encode($data);
                $queue_failed_message->retry_count  = $data['retry'];
                $queue_failed_message->error_message  = $e->getMessage();
                if (!$queue_failed_message->save()){
                    $this->logger->error('TaskWorkerResultHookConsumerException,Retry limit reached, write failed.');
                }
                // 完成消费
                return Result::ACK;
            }
            $data['retry']++;
            // 获取生产者
            $task_worker_result_hook_producer = new TaskWorkerResultHookProducer($data);
            // 发送到队列
            $this->producer->produce($task_worker_result_hook_producer);
            // 完成消费
            return Result::ACK;
        }
    }
}
