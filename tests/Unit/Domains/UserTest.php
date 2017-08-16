<?php

namespace Tests\Unit\Domains;

use stdClass;
use Exception;
use Mockery as m;
use EverestBill\Domains\User;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;

class UserTest extends \PHPUnit\Framework\TestCase
{
    use MockeryPHPUnitIntegration;

    public function setUp()
    {
        $this->auth         = m::mock('Cartalyst\Sentinel\Sentinel');
        $this->user         = m::mock('EverestBill\Models\User');
        $this->event        = m::mock('Illuminate\Events\Dispatcher');
        $this->activation   = m::mock('Cartalyst\Sentinel\Activations\IlluminateActivationRepository');
        $this->customerFlow = m::mock('EverestBill\Domains\CustomerFlow');

        $this->userDomain = new User(
            $this->auth,
            $this->user,
            $this->event,
            $this->activation,
            $this->customerFlow
        );
    }

    public function test_register_WhenCalled_ReturnUserModel()
    {
        $data = ['email' => 'test@test.com', 'password' => 'test123'];

        $userObject = m::mock('Cartalyst\Sentinel\Users\UserInterface');

        $userObject->id    = 1;
        $userObject->email = $data['email'];

        $this->auth
            ->shouldReceive('register')
            ->andReturn($userObject)->once();

        $this->activation
            ->shouldReceive('create')
            ->andReturn($userObject)->once();

        $this->event
            ->shouldReceive('fire');

        $user = $this->userDomain->register($data);

        $this->assertTrue(is_object($user));
        $this->assertObjectHasAttribute('id', $user);
        $this->assertObjectHasAttribute('email', $user);
        $this->assertEquals(1, $user->id);
        $this->assertEquals($data['email'], $user->email);
    }

    public function test_register_WhenCalledButDatabaseHasIssue_ThrowAnException()
    {
        $data = ['email' => 'test@test.com', 'password' => 'test123'];

        $this->auth->shouldReceive('register')
            ->andReturn(false)->once();

        $this->expectException(Exception::class);

        $user = $this->userDomain->register($data);
    }

    public function test_findById_WhenCalledWithId_ReturnCorrectUserModel()
    {
        $userObject = m::mock('Cartalyst\Sentinel\Users\UserInterface');

        $userObject->id    = 1;
        $userObject->email = 'test@test.com';

        $this->auth
            ->shouldReceive('findById')
            ->andReturn($userObject)->once();

        $user = $this->userDomain->findById($userObject->id);

        $this->assertTrue(is_object($user));
        $this->assertObjectHasAttribute('id', $user);
        $this->assertObjectHasAttribute('email', $user);
        $this->assertEquals(1, $user->id);
        $this->assertEquals($userObject->email, $user->email);
    }

    public function test_findByActivationCode_WhenCalledWithActivationCode_ReturnCorrectUserModel()
    {
        $userObject   = m::mock('Cartalyst\Sentinel\Users\UserInterface');
        $helperObject = m::mock();

        $activationObject          = new stdClass();
        $activationObject->user_id = 1;

        $userObject->id    = 1;
        $userObject->email = 'test@test.com';

        $this->activation
            ->shouldReceive('where')
            ->andReturn($helperObject)->once();

        $helperObject
            ->shouldReceive('first')
            ->andReturn($activationObject)->once();

        $this->auth
            ->shouldReceive('findById')
            ->andReturn($userObject)->once();

        $user = $this->userDomain->findByActivationCode('test_code');

        $this->assertTrue(is_object($user));
        $this->assertObjectHasAttribute('id', $user);
        $this->assertObjectHasAttribute('email', $user);
        $this->assertEquals(1, $user->id);
        $this->assertEquals($userObject->email, $user->email);
    }

    public function test_findByActivationCode_WhenCalledButActivationModelWasNotFound_ThrowAnException()
    {
        $userObject   = m::mock('Cartalyst\Sentinel\Users\UserInterface');
        $helperObject = m::mock();

        $activationObject          = new stdClass();
        $activationObject->user_id = 1;

        $userObject->id    = 1;
        $userObject->email = 'test@test.com';

        $this->activation
            ->shouldReceive('where')
            ->andReturn($helperObject)->once();

        $helperObject
            ->shouldReceive('first')
            ->andReturn(null)->once();

        $this->expectException(Exception::class);

        $this->userDomain->findByActivationCode('test_code');
    }
}
