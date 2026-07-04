<?php

namespace App\Service;

use Hyperf\Contract\SessionInterface;
use Hyperf\Database\Model\Model;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Paginator\LengthAwarePaginator;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\Log\LoggerInterface;

abstract class AbstractService
{
    #[Inject]
    protected RedisService $redis;

    #[Inject]
    protected SessionInterface $session;

    #[Inject]
    protected LoggerInterface $logger;

    #[Inject]
    protected EventDispatcherInterface $event;

    protected Model $model;

    /**
     * 分页
     * @param int $member_id 用户ID
     * @param int $page 页码
     * @param int $per_page 每页记录数
     * @param array $filters 过滤条件
     * @param array $with 预加载关系
     * @param array $orderBy 排序条件
     * @return LengthAwarePaginator
     */
    public function paginate(int $member_id, int $page = 1, int $per_page = 10, array $filters = [], array $with = [], array $orderBy = ['created_at' => 'desc']) : LengthAwarePaginator
    {
        // 获取构造器
        $query = $this->model::query();

        // 查询自己
        $query->where('member_id', $member_id);

        // 预加载关系
        if (!empty($with)) {
            $query->with($with);
        }

        // 排序
        if(!empty($orderBy)) {
            foreach ($orderBy as $field => $direction) {
                $query->orderBy($field, $direction);
            }
        }

        // 根据过滤条件构建查询
        foreach ($filters as $field => $value) {
            // 仅添加非空过滤条件,避免对空值进行查询
            if ($value !== '' && $value !== null && $field !== 'page' && $field !== 'per_page') {
                // 对于时间范围过滤，假设字段名以 _start 或 _end 结尾
                if (str_ends_with($field, '_start')) {
                    $query->where(str_replace('_start', '', $field), '>=', $value);
                } elseif (str_ends_with($field, '_end')) {
                    $query->where(str_replace('_end', '', $field), '<=', $value);
                } else if (is_numeric($value)) {
                    // 对于数值类型的字段，使用精确匹配
                    $query->where($field, $value);
                } else {
                    // 对于其他类型的字段，使用模糊匹配
                    $query->where($field, 'like', "%{$value}%");
                }
            }
        }

        // 查询分页结果
        $pagination = $query->paginate($per_page, ['*'], 'page', $page);

        // 追加查询参数到分页链接
        $pagination->appends(array_filter($filters, fn ($value) => $value !== '' && $value !== null));

        // 返回分页结果
        return $pagination;
    }
}