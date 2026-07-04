<?php

declare(strict_types=1);

namespace App\Model;

use Hyperf\DbConnection\Model\Model;

/**
 * @property int $id 
 * @property int $ticket_id 
 * @property string $sender 
 * @property string $content 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 */
class TicketMessage extends Model
{
    /**
     * The table associated with the model.
     */
    protected ?string $table = 'ticket_message';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = [];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['id' => 'integer', 'ticket_id' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}
