<?php

declare(strict_types=1);

namespace App\Model;

use Hyperf\DbConnection\Model\Model;

/**
 * @property int $id 
 * @property int $member_id 
 * @property int $task_type_id 
 * @property string $order_no 
 * @property string $amount 
 * @property string $payload 
 * @property string $answer 
 * @property string $status 
 * @property string $result 
 * @property int $is_consensus 
 * @property string $completed_at 
 * @property string $expired_at 
 * @property string $cancel_at 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 */
class TaskWorker extends Model
{
    /**
     * The table associated with the model.
     */
    protected ?string $table = 'task_worker';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = [];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['id' => 'integer', 'member_id' => 'integer', 'task_type_id' => 'integer', 'is_consensus' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}
