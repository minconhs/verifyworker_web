<?php

declare(strict_types=1);

namespace App\Model;

use Hyperf\DbConnection\Model\Model;

/**
 * @property int $id 
 * @property int $member_id 
 * @property int $total_days 
 * @property int $continuous_days 
 * @property int $max_continuous_days 
 * @property string $last_checkin_date 
 * @property string $total_reward_amount 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 */
class MemberCheckinStat extends Model
{
    /**
     * The table associated with the model.
     */
    protected ?string $table = 'member_checkin_stats';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = [];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['id' => 'integer', 'member_id' => 'integer', 'total_days' => 'integer', 'continuous_days' => 'integer', 'max_continuous_days' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}
