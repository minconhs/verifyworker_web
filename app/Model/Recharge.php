<?php

declare(strict_types=1);

namespace App\Model;

use Hyperf\DbConnection\Model\Model;

/**
 * @property int $id 
 * @property int $member_id 
 * @property string $order_no 
 * @property string $amount 
 * @property int $status 
 * @property string $method 
 * @property \Carbon\Carbon $paid_at
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 */
class Recharge extends Model
{
    /**
     * The table associated with the model.
     */
    protected ?string $table = 'recharge';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = [];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['id' => 'integer', 'member_id' => 'integer', 'status' => 'integer', 'paid_at' => 'datetime', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}
