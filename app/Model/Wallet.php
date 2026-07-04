<?php

declare(strict_types=1);

namespace App\Model;

use Hyperf\DbConnection\Model\Model;

/**
 * @property int $id 
 * @property int $member_id 
 * @property string $recharge_balance 
 * @property string $recharge_frozen 
 * @property string $task_balance 
 * @property string $task_frozen 
 * @property string $commission_balance 
 * @property string $commission_frozen 
 * @property int $version 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 */
class Wallet extends Model
{
    /**
     * The table associated with the model.
     */
    protected ?string $table = 'wallet';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = [];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['id' => 'integer', 'member_id' => 'integer', 'version' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}
