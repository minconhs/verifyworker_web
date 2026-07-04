<?php

declare(strict_types=1);

namespace App\Model;

use Hyperf\Database\Model\Relations\BelongsTo;
use Hyperf\DbConnection\Model\Model;

/**
 * @property int $id 
 * @property int $member_id 
 * @property int $form_member_id 
 * @property string $amount 
 * @property string $order_no
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 */
class TaskCommission extends Model
{
    /**
     * The table associated with the model.
     */
    protected ?string $table = 'task_commission';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = [];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['id' => 'integer', 'member_id' => 'integer', 'form_member_id' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];

    /**
     * 关联会员模型
     * @return BelongsTo
     */
    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class, 'member_id', 'id');
    }

    /**
     * 关联来自会员模型
     * @return BelongsTo
     */
    public function fromMember(): BelongsTo
    {
        return $this->belongsTo(Member::class, 'form_member_id', 'id');
    }
}
