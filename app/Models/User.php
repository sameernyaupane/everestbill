<?php
namespace EverestBill\Models;

use Cartalyst\Sentinel\Users\EloquentUser as SentinelUser;

class User extends SentinelUser
{
    /**
     * Fillable attributes
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'password',
        'full_name',
        'permissions',
    ];

    /**
     * Get the plan associated with the order.
     */
    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id', 'id');
    }
}
