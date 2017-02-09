<?php

namespace EverestBill\Models;

use Cartalyst\Sentinel\Users\EloquentUser as SentinelUser;

class User extends SentinelUser
{
    /**
     * Fillable attributes
     * @var array
     */
    protected $fillable = [
        'email',
        'password',
        'full_name',
        'permissions',
    ];
}
