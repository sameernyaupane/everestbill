<?php

namespace EverestBill\Domains;

use Exception;
use Illuminate\Events\Dispatcher;
use EverestBill\Events\UserRegistered;
use Cartalyst\Sentinel\Sentinel as Auth;
use Cartalyst\Sentinel\Activations\IlluminateActivationRepository as Activation;

class User
{
    /**
     * Event Dispatcher
     * @var object
     */
    protected $event;

    /**
     * Authentication Provider
     * @var object
     */
    protected $auth;

    /**
     * Activation Provider
     * @var object
     */
    protected $activation;

    public function __construct(
        Auth $auth, 
        Dispatcher $event,
        Activation $activation
    )
    {
        $this->auth       = $auth;
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
     * @param  integer $userId
     * @return object
     */
    public function findById($userId)
    {
        return $this->auth->findById($userId);
    }
}
