<?php

declare(strict_types=1);

namespace App\Model;

use Hyperf\DbConnection\Model\Model;

/**
 * @property int $id 
 * @property int $sort 
 * @property string $name 
 * @property string $code 
 * @property string $price 
 * @property int $status 
 * @property string $icon 
 * @property string $describe 
 * @property string $explanation 
 * @property string $success_rate 
 * @property string $response_second 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 */
class TaskPricing extends Model
{
    /**
     * The table associated with the model.
     */
    protected ?string $table = 'task_pricing';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = [];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['id' => 'integer', 'sort' => 'integer', 'status' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}
