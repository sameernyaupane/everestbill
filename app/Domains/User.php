<?php

namespace EverestBill\Domains;

use Exception;
use Illuminate\Events\Dispatcher;
use EverestBill\Events\UserRegistered;
use Cartalyst\Sentinel\Sentinel as Auth;
use EverestBill\Models\User as UserModel;
use Cartalyst\Sentinel\Activations\EloquentActivation as Activation;

class User
{
    /**
     * Event Dispatcher Instance
     * 
     * @var object
     */
    protected $event;

    /**
     * Authentication Provider Instance
     * 
     * @var object
     */
    protected $auth;

    /**
     * User Model Instance
     * 
     * @var object
     */
    protected $user;

    /**
     * Activation Provider Instance
     * 
     * @var object
     */
    protected $activation;

    public function __construct(
        Auth $auth, 
        UserModel $user,
        Dispatcher $event,
        Activation $activation
    )
    {
        $this->auth       = $auth;
        $this->user       = $user;
        $this->event      = $event;
        $this->activation = $activation;
    }

    /**
     * User registration method
     * @param  array $data
     * @return object
     */
    public function register($data)
    {
        if(!$user = $this->auth->register($data)) {
            throw new Exception(
                'An error occured while registering. Please try again.'
            );
        }

        $this->activation->create($user);

        $this->event->fire(new UserRegistered($user->id));

        return $user;
    }

    /**
     * Find user by ID
     * 
     * @param  integer $userId
     * @return object
     */
    public function findById($userId)
    {
        return $this->auth->findById($userId);
    }

    /**
     * Find user by ID
     * 
     * @param  string $code
     * @return object
     */
    public function findByActivationCode($code)
    {
        $activation = $this->activation->where('code', $code)->first();

        if (count($activation)) {
            $user = $this->findById($activation->user_id);
        } else {
            throw new Exception('Code not found.');
        }

        return $user;
    }
}
