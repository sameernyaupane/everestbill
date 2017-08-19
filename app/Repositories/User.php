<?php
namespace EverestBill\Repositories;

use Cartalyst\Sentinel\Sentinel as Auth;
use EverestBill\Models\User as UserModel;
use League\Flysystem\Exception;

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

    /**
     * Get the latest order amount of the current logged in user
     *
     * @return mixed
     *
     * @throws Exception
     */
    public function getLatestOrder()
    {
        $user = $this->auth->getUser();

        $latestOrder = $user->orders()->orderBy('created_at', 'desc')->first();

        $latestOrder->planName = $latestOrder->plan->plan_name;

        if ($latestOrder->billing_cycle == 'monthly') {
            $latestOrder->amount = $latestOrder->plan->pricing->monthly_price;
        } elseif($latestOrder->billing_cycle == 'yearly') {
            $latestOrder->amount = $latestOrder->plan->pricing->yearly_price;
        } else {
            throw new Exception('Billing cycle not found.');
        }

        return $latestOrder;
    }
}