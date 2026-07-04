<?php

declare(strict_types=1);

namespace App\Model;

use Hyperf\DbConnection\Model\Model;

/**
 * @property int $id 
 * @property int $member_id 
 * @property int $channel_email 
 * @property int $notice_security 
 * @property int $notice_product 
 * @property int $notice_policy 
 * @property int $notice_event 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 */
class MemberSetting extends Model
{
    /**
     * The table associated with the model.
     */
    protected ?string $table = 'member_setting';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = [];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['id' => 'integer', 'member_id' => 'integer', 'channel_email' => 'integer', 'notice_security' => 'integer', 'notice_product' => 'integer', 'notice_policy' => 'integer', 'notice_event' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}
