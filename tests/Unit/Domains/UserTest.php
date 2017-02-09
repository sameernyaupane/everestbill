<?php
namespace Tests\Unit\Domains;

use KosmoBill\Domains\User;
use Cartalyst\Sentinel\Sentinel as Auth;
use Cartalyst\Sentinel\Activations\IlluminateActivationRepository as Activation;

class UserTest extends \PHPUnit\Framework\TestCase
{
    public function test_register_WhenCalled_ReturnUserModel()
    {
        $auth       = $this->getMockBuilder('Cartalyst\Sentinel\Sentinel')->getMock();
        $activation = $this->getMockBuilder('Activation')->getMock();

        $user = new User($auth, $activation);

        $userModel = $user->register($data);
    }
}
