<?php

declare(strict_types=1);

namespace App\Model;

use Hyperf\DbConnection\Model\Model;

/**
 * @property int $id 
 * @property int $sort 
 * @property string $title 
 * @property string $summary 
 * @property string $content 
 * @property string $thumbnail 
 * @property string $status 
 * @property string $category 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 */
class SystemNotice extends Model
{
    /**
     * The table associated with the model.
     */
    protected ?string $table = 'system_notice';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = [];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['id' => 'integer', 'sort' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}
