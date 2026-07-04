<?php

declare(strict_types=1);

namespace App\Model;

use Hyperf\DbConnection\Model\Model;

/**
 * @property int $id 
 * @property int $member_id 
 * @property string $order_no 
 * @property string $subject 
 * @property string $description 
 * @property string $priority 
 * @property string $category 
 * @property string $status 
 * @property string $closed_at 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 */
class Ticket extends Model
{
    /**
     * The table associated with the model.
     */
    protected ?string $table = 'ticket';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = [];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['id' => 'integer', 'member_id' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}
