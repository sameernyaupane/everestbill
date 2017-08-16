<?php

namespace Tests\Unit\Http\Controllers\Frontend;

use stdClass;
use Exception;
use Mockery as m;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use EverestBill\Http\Controllers\Frontend\Auth\Register;

class RegisterTest extends \PHPUnit\Framework\TestCase
{
    use MockeryPHPUnitIntegration;

    public function setUp()
    {
        $this->view       = m::mock('Illuminate\View\Factory');
        $this->userDomain = m::mock('EverestBill\Domains\User');
        $this->auth       = m::mock('Cartalyst\Sentinel\Sentinel');
        $this->redirect   = m::mock('Illuminate\Routing\Redirector');
        $this->request    = m::mock('EverestBill\Http\Requests\RegistrationData');

        $this->register = new Register();
    }

    public function test_getForm_WhenCalled_ReturnViewInstance()
    {
        $this->view->shouldReceive('make')->andReturn(new stdClass)->once();

        $viewInstance = $this->register->getForm($this->view);

        $this->assertTrue(is_object($viewInstance));
    }

    private function prepare_perform_mocks()
    {
        $this->orderDomain  = m::mock('EverestBill\Domains\Order');
        $this->customerFlow = m::mock('EverestBill\Domains\CustomerFlow');
        $this->session      = m::mock('Illuminate\Session\SessionManager');
    }

    public function test_perform_WhenCalledAndCustomerFlowIsInSession_ReturnRedirectInstance()
    {
        $this->prepare_perform_mocks();

        $role = m::mock();
        $user = m::mock('Cartalyst\Sentinel\Users\UserInterface');
        $user->id = 1;

        $role->shouldReceive('users')->andReturnSelf()->once();
        $role->shouldReceive('attach')->once();

        $this->request->shouldReceive('all')->andReturn(true)->once();
        $this->userDomain->shouldReceive('register')->andReturn($user)->once();
        $this->auth->shouldReceive('findRoleById')->andReturn($role)->once();
        $this->auth->shouldReceive('login')->once();

        $this->customerFlow->shouldReceive('isInSession')
            ->andReturn(true)
            ->once();

        $this->redirect->shouldReceive('route')->andReturnSelf()->once();

        $this->redirect
            ->shouldReceive('withSuccess')
            ->andReturnUsing(function ($message) {
                $this->redirect->message = $message;
                return $this->redirect;
            });

        $this->orderDomain
            ->shouldReceive('saveSessionItemsToDatabase')
            ->once();

        $this->session->shouldReceive('get')->atLeast()->once();

        $redirectInstance = $this->register->perform(
            $this->auth,
            $this->userDomain,
            $this->redirect,
            $this->orderDomain,
            $this->session,
            $this->request,
            $this->customerFlow
        );

        $this->assertTrue(is_object($redirectInstance));
        $this->assertTrue(is_string($redirectInstance->message));
    }

    public function test_perform_WhenCalledAndCustomerFlowIsNotInSession_ReturnRedirectInstance()
    {
        $this->prepare_perform_mocks();

        $this->role = m::mock();
        $this->user = m::mock('Cartalyst\Sentinel\Users\UserInterface');

        $this->role->shouldReceive('users')->andReturnSelf()->once();
        $this->role->shouldReceive('attach')->once();

        $this->request->shouldReceive('all')->andReturn(true)->once();
        $this->userDomain->shouldReceive('register')->andReturn($this->user)->once();
        $this->auth->shouldReceive('findRoleById')->andReturn($this->role)->once();
        $this->auth->shouldReceive('login')->once();

        $this->customerFlow->shouldReceive('isInSession')->andReturn(false)->once();

        $this->redirect->shouldReceive('route')->andReturnSelf()->once();

        $this->redirect
            ->shouldReceive('withSuccess')
            ->andReturnUsing(function ($message) {
                $this->redirect->message = $message;
                return $this->redirect;
            });

        $redirectInstance = $this->register->perform(
            $this->auth,
            $this->userDomain,
            $this->redirect,
            $this->orderDomain,
            $this->session,
            $this->request,
            $this->customerFlow
        );

        $this->assertTrue(is_object($redirectInstance));
        $this->assertTrue(is_string($redirectInstance->message));
    }

    public function test_perform_WhenCalledAndExceptionThrown_ReturnRedirectInstance()
    {
        $this->prepare_perform_mocks();

        $this->customerFlow = m::mock('EverestBill\Domains\CustomerFlow');

        $this->userDomain
            ->shouldReceive('register')
            ->andReturnUsing(function () {
                throw new Exception();
            });

        $this->redirect->shouldReceive('back')->andReturnSelf()->once();
        $this->redirect->shouldReceive('withInput')->andReturnSelf()->once();

        $this->redirect
            ->shouldReceive('withError')
            ->andReturnUsing(function ($message) {
                $this->redirect->message = $message;
                return $this->redirect;
            });

        $redirectInstance = $this->register->perform(
            $this->auth,
            $this->userDomain,
            $this->redirect,
            $this->orderDomain,
            $this->session,
            $this->request,
            $this->customerFlow
        );

        $this->assertTrue(is_object($redirectInstance));
        $this->assertTrue(is_string($redirectInstance->message));
    }

    public function test_activate_WhenCalled_ReturnRedirectInstance()
    {
        $this->user       = m::mock('Cartalyst\Sentinel\Users\UserInterface');
        $this->activation = m::mock('Cartalyst\Sentinel\Activations\IlluminateActivationRepository');

        $this->activation->shouldReceive('complete')->once();
        $this->userDomain->shouldReceive('findByActivationCode')->andReturn($this->user)->once();

        $this->redirect->shouldReceive('route')->andReturnSelf()->once();

        $this->redirect
            ->shouldReceive('withSuccess')
            ->andReturnUsing(function ($message) {
                $this->redirect->message = $message;
                return $this->redirect;
            });

        $redirectInstance = $this->register->activate(
            'code',
            $this->redirect,
            $this->userDomain,
            $this->activation
        );

        $this->assertTrue(is_object($redirectInstance));
        $this->assertTrue(is_string($redirectInstance->message));
    }

    public function test_activate_WhenCalledAndExceptionThrown_ReturnRedirectInstance()
    {
        $this->user       = m::mock('Cartalyst\Sentinel\Users\UserInterface');
        $this->activation = m::mock('Cartalyst\Sentinel\Activations\IlluminateActivationRepository');

        $this->userDomain->shouldReceive('findByActivationCode')->andReturnUsing(function () {
            throw new Exception();
        });

        $this->redirect->shouldReceive('back')->andReturnSelf()->once();
        $this->redirect->shouldReceive('withInput')->andReturnSelf()->once();

        $this->redirect
            ->shouldReceive('withError')
            ->andReturnUsing(function ($message) {
                $this->redirect->message = $message;
                return $this->redirect;
            });

        $redirectInstance = $this->register->activate(
            'code',
            $this->redirect,
            $this->userDomain,
            $this->activation
        );

        $this->assertTrue(is_object($redirectInstance));
        $this->assertTrue(is_string($redirectInstance->message));
    }

    public function test_completeCheckout_WhenCalled_ReturnRedirectInstance()
    {
        $this->user           = m::mock('Cartalyst\Sentinel\Users\UserInterface');
        $this->activation     = m::mock('Cartalyst\Sentinel\Activations\IlluminateActivationRepository');
        $this->userRepository = m::mock('EverestBill\Repositories\User');

        $this->activation->shouldReceive('complete')->once();
        $this->userDomain->shouldReceive('findByActivationCode')->andReturn($this->user)->once();
        $this->userRepository->shouldReceive('loginByInstance')->once();

        $this->redirect->shouldReceive('route')->andReturnSelf()->once();

        $this->redirect
            ->shouldReceive('withSuccess')
            ->andReturnUsing(function ($message) {
                $this->redirect->message = $message;
                return $this->redirect;
            });

        $redirectInstance = $this->register->completeCheckout(
            'code',
            $this->redirect,
            $this->userDomain,
            $this->activation,
            $this->userRepository
        );

        $this->assertTrue(is_object($redirectInstance));
        $this->assertTrue(is_string($redirectInstance->message));
    }

    public function test_completeCheckout_WhenCalledAndExceptionThrown_ReturnRedirectInstance()
    {
        $this->user           = m::mock('Cartalyst\Sentinel\Users\UserInterface');
        $this->activation     = m::mock('Cartalyst\Sentinel\Activations\IlluminateActivationRepository');
        $this->userRepository = m::mock('EverestBill\Repositories\User');

        $this->userDomain->shouldReceive('findByActivationCode')->andReturnUsing(function () {
            throw new Exception();
        });

        $this->redirect->shouldReceive('back')->andReturnSelf()->once();
        $this->redirect->shouldReceive('withInput')->andReturnSelf()->once();

        $this->redirect
            ->shouldReceive('withError')
            ->andReturnUsing(function ($message) {
                $this->redirect->message = $message;
                return $this->redirect;
            });

        $redirectInstance = $this->register->completeCheckout(
            'code',
            $this->redirect,
            $this->userDomain,
            $this->activation,
            $this->userRepository
        );

        $this->assertTrue(is_object($redirectInstance));
        $this->assertTrue(is_string($redirectInstance->message));
    }
}