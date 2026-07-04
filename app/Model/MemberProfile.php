<?php

declare(strict_types=1);

namespace App\Model;

use Hyperf\DbConnection\Model\Model;

/**
 * @property int $id 
 * @property int $member_id 
 * @property string $first_name 
 * @property string $last_name 
 * @property string $country 
 * @property string $state 
 * @property string $city 
 * @property string $postal_code 
 * @property string $address_line1 
 * @property string $address_line2 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 */
class MemberProfile extends Model
{
    /**
     * The table associated with the model.
     */
    protected ?string $table = 'member_profile';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = [];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['id' => 'integer', 'member_id' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}
