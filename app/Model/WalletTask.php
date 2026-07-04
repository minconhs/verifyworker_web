<?php

declare(strict_types=1);

namespace App\Model;

use Hyperf\DbConnection\Model\Model;

/**
 * @property int $id 
 * @property int $member_id 
 * @property string $balance 
 * @property string $frozen 
 * @property int $version 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 */
class WalletTask extends Model
{
    /**
     * The table associated with the model.
     */
    protected ?string $table = 'wallet_task';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = [];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['id' => 'integer', 'member_id' => 'integer', 'version' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}
