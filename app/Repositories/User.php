<?php
namespace EverestBill\Repositories;

use Cartalyst\Sentinel\Sentinel as Auth;
use EverestBill\Models\User as UserModel;

class User
{
    /**
     * UserModel instance
     *     
     * @var UserModel
     */
    private $user;

    /**
     * Auth instance
     *     
     * @var Auth
     */
    private $auth;

    /**
     * User constructor
     * 
     * @param Auth      $auth
     * @param UserModel $user
     */
    public function __construct(Auth $auth, UserModel $user)
    {
        $this->auth = $auth;
        $this->user = $user;
    }

    /**
     * Get all of the users
     * 
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAll()
    {
        return $this->user->all();
    }

    /**
     * Login by given instance
     * 
     * @param  User $user
     */
    public function loginByInstance($user)
    {
        $this->auth->login($user);
    }
}