<?php

declare(strict_types=1);

namespace App\Model;

use Hyperf\DbConnection\Model\Model;

/**
 * @property int $id 
 * @property string $queue_name 
 * @property string $message_body 
 * @property int $retry_count 
 * @property string $error_message 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 */
class QueueFailedMessage extends Model
{
    /**
     * The table associated with the model.
     */
    protected ?string $table = 'queue_failed_message';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = [];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['id' => 'integer', 'retry_count' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}
