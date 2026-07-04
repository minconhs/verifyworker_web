<?php

declare(strict_types=1);

namespace App\Model;

use Hyperf\DbConnection\Model\Model;

/**
 * @property int $id 
 * @property int $sort 
 * @property string $amount 
 * @property int $daily_limit 
 * @property int $monthly_limit 
 * @property int $status 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 */
class WithdrawalAmount extends Model
{
    /**
     * The table associated with the model.
     */
    protected ?string $table = 'withdrawal_amount';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = [];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['id' => 'integer', 'sort' => 'integer', 'daily_limit' => 'integer', 'monthly_limit' => 'integer', 'status' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}
