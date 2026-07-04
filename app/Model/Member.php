<?php

declare(strict_types=1);

namespace App\Model;

use Hyperf\DbConnection\Model\Model;

/**
 * @property int $id 
 * @property int $parent_id 
 * @property string $username 
 * @property string $password 
 * @property string $payment_password 
 * @property string $email 
 * @property int $is_email_verified 
 * @property string $register_ip 
 * @property string $invite_code 
 * @property string $role 
 * @property int $status 
 * @property string $session 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 */
class Member extends Model
{
    /**
     * The table associated with the model.
     */
    protected ?string $table = 'member';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = [];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = ['id' => 'integer', 'parent_id' => 'integer', 'is_email_verified' => 'integer', 'status' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}
