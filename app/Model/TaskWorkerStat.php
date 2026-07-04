<?php

declare(strict_types=1);

namespace App\Model;

use Hyperf\DbConnection\Model\Model;

/**
 * @property int $id 
 * @property int $member_id 
 * @property string $task_type 
 * @property int $total 
 * @property int $completed 
 * @property int $cancel 
 * @property int $failed 
 * @property int $timeout 
 * @property string $date 
 * @property string $total_amount 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 */
class TaskWorkerStat extends Model
{
    /**
     * The table associated with the model.
     */
    protected ?string $table = 'task_worker_stats';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = [];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['id' => 'integer', 'member_id' => 'integer', 'total' => 'integer', 'completed' => 'integer', 'cancel' => 'integer', 'failed' => 'integer', 'timeout' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}
