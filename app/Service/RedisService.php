<?php

namespace App\Service;

use Hyperf\Di\Annotation\Inject;
use Hyperf\Redis\Redis;
use Psr\Log\LoggerInterface;

class RedisService
{
    #[Inject]
    protected Redis $redis;

    #[Inject]
    protected LoggerInterface $logger;

    /**
     * redis安全删除
     * @param string $key
     * @return bool
     */
    public function del(string $key): bool
    {
        try {
            return $this->redis->del($key);
        } catch (\RedisException $e) {
            return false;
        }
    }

    /**
     * redis安全获取
     * @param string $key
     * @return bool|string
     */
    public function get(string $key): bool|string
    {
        try {
            return $this->redis->get($key);
        } catch (\RedisException $e) {
            return false;
        }
    }

    /**
     * redis安全设置
     * @param string $key
     * @param int $ttl
     * @param string $value
     * @return bool
     */
    public function set(string $key, int $ttl, string $value): bool
    {
        try {
            return $this->redis->setex($key, $ttl, $value);
        } catch (\RedisException $e) {
            return false;
        }
    }

    /**
     * redis安全设置
     * @param string $key
     * @param int $value
     * @return bool|int
     */
    public function incr(string $key, int $value = 1): bool|int
    {
        try {
            return $this->redis->incr($key, $value);
        } catch (\RedisException $e) {
            return false;
        }
    }

    /**
     * redis安全设置
     * @param string $key
     * @param int $ttl
     * @return bool
     */
    public function expire(string $key, int $ttl): bool
    {
        try {
            return $this->redis->expire($key, $ttl);
        } catch (\RedisException $e) {
            return false;
        }
    }

    /**
     * 安全管道
     * @param callable $callback
     * @return array
     */
    public function pipeline(callable $callback): array
    {
        return $this->redis->pipeline($callback);
    }
}