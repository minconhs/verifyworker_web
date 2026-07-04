<?php

declare(strict_types=1);

namespace App\Process;

use App\Amqp\Producer\TaskWorkerTimeOutProducer;
use Hyperf\Amqp\Producer;
use Hyperf\Contract\StdoutLoggerInterface;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Process\AbstractProcess;
use Hyperf\Process\Annotation\Process;
use Hyperf\Redis\Redis;
use Swoole\Timer;

#[Process(name: 'TaskWorkerTimeOutProcess')]
class TaskWorkerTimeOutProcess extends AbstractProcess
{
    #[Inject]
    protected Producer $producer;

    #[Inject]
    protected StdoutLoggerInterface $logger;

    #[Inject]
    protected Redis $redis;

    private bool $running = false;

    protected string $source_key = 'task_worker_expire';

    protected string $source_key_processing = 'task_worker_expire_processing';

    public function handle(): void
    {
        Timer::tick(1000, function() {$this->flush();});

        while (true) {
            sleep(1);
        }
    }

    protected function flush(): void
    {
        // 仅在非运行状态才继续执行
        if ($this->running) {
            return;
        }

        // 改变运行状态
        $this->running = true;

        try {
            // 使用Lua脚本原子批量拉取过期订单并移动到处理中的有序集合，确保数据安全和处理效率，避免重复处理
            $batch = $this->redis->eval($this->lua_move_to_processing_script(), [$this->source_key, $this->source_key_processing, time(), 1000], 2);
            if (count($batch) === 0) {
                return;
            }

            $this->logger->debug("拉取到TaskWorker过期订单数量: " . count($batch));

            // 待处理订单
            $wait_orders = [];

            // 发送到订单过期队列
            foreach ($batch as $order_no) {
                $taskWorkerTimeOutProcess = new TaskWorkerTimeOutProducer($order_no);
                $send_task_worker_timeout_process = $this->producer->produce($taskWorkerTimeOutProcess);
                if ($send_task_worker_timeout_process) {
                    $wait_orders[] = $order_no;
                }
            }

            if (count($wait_orders) === 0) {
                return;
            }


            // 批量从处理中的有序集合中删除已处理的订单，确保数据一致性和避免重复处理
            $this->redis->eval($this->lua_ack_processing_script(), [$this->source_key_processing, implode(',', $wait_orders)],1);
        } catch (\Throwable $e) {
            try {
                $this->logger->error("处理过期订单时发生异常: " . $e->getMessage());
                // 如果处理过程中发生异常，将订单从处理中的有序集合移回原始有序集合，确保订单不会丢失并且可以在下一轮继续处理
                if (isset($batch) && count($batch) > 0) {
                    $this->logger->info("将处理失败的订单移回原始有序集合，订单数量: " . count($batch));
                    $this->redis->eval($this->lua_return_to_source_script(), [$this->source_key_processing, $this->source_key, implode(',', array_map(fn($item) => json_encode($item), $batch))], 2);
                }
            } catch (\Throwable $e) {
                $this->logger->error("在处理异常时发生另一个异常: " . $e->getMessage());
            }
        } finally {
            $this->running = false;
        }
    }

    /**
     * Lua脚本：将过期订单从原始有序集合移动到处理中的有序集合，确保原子性操作，避免重复处理
     * @return string
     */
    private function lua_move_to_processing_script(): string
    {
        return <<<LUA
        local src   = KEYS[1]
        local proc  = KEYS[2]
        local now   = tonumber(ARGV[1])
        local limit = tonumber(ARGV[2])
        local members = redis.call('ZRANGEBYSCORE', src, '-inf', now, 'LIMIT', 0, limit)
        if #members == 0 then
          return {}
        end
        for i = 1, #members do
          local m = members[i]
          local s = redis.call('ZSCORE', src, m)
          if s then
            redis.call('ZADD', proc, s, m)
            redis.call('ZREM', src, m)
          end
        end
        
        return members
        LUA;
    }

    /**
     * Lua脚本：将处理完成的订单从处理中的有序集合中删除，确保原子性操作，避免重复处理
     * @return string
     */
    private function lua_ack_processing_script(): string
    {
        return <<<LUA
        local proc = KEYS[1]
        if #ARGV == 0 then
          return 0
        end
        
        return redis.call('ZREM', proc, unpack(ARGV))
        LUA;
    }

    /**
     * Lua脚本：将处理失败的订单从处理中的有序集合移回原始有序集合，确保原子性操作，避免重复处理
     * @return string
     */
    private function lua_return_to_source_script(): string
    {
        return <<<LUA
        local proc = KEYS[1]
        local src  = KEYS[2]
        if #ARGV == 0 then
          return 0
        end
        
        for i = 1, #ARGV do
          local m = ARGV[i]
          local s = redis.call('ZSCORE', proc, m)
          if s then
            redis.call('ZADD', src, s, m)
            redis.call('ZREM', proc, m)
          end
        end
        
        return #ARGV
        LUA;
    }
}
