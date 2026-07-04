<?php

declare(strict_types=1);

namespace App\Model;

use Hyperf\Database\Model\Relations\BelongsTo;
use Hyperf\DbConnection\Model\Model;

/**
 * @property int $id 
 * @property int $member_id 
 * @property string $amount 
 * @property string $balance_before 
 * @property string $transaction_type 
 * @property string $operation_type 
 * @property string $wallet_type 
 * @property string $order_no
 * @property string $description 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 */
class WalletFlow extends Model
{
    /**
     * The table associated with the model.
     */
    protected ?string $table = 'wallet_flow';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = [];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['id' => 'integer', 'member_id' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];

    /**
     * 关联会员模型
     * @return BelongsTo
     */
    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class, 'member_id', 'id');
    }
}
