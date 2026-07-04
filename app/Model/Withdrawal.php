<?php

declare(strict_types=1);

namespace App\Model;

use Hyperf\DbConnection\Model\Model;

/**
 * @property int $id 
 * @property int $member_id 
 * @property int $amount_id 
 * @property string $method 
 * @property string $order_no 
 * @property string $amount 
 * @property string $account 
 * @property int $status 
 * @property string $status_message 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 */
class Withdrawal extends Model
{
    /**
     * The table associated with the model.
     */
    protected ?string $table = 'withdrawal';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = [];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['id' => 'integer', 'member_id' => 'integer', 'amount_id' => 'integer', 'status' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}
