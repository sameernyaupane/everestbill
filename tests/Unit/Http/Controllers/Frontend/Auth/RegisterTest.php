<?php

namespace Tests\Unit\Http\Controllers\Frontend;

use stdClass;
use Mockery as m;
use EverestBill\Http\Controllers\Frontend\Auth\Register;

class RegisterTest extends \PHPUnit\Framework\TestCase
{
    public function setUp()
    {
        $this->view       = m::mock('Illuminate\View\Factory');
        $this->auth       = m::mock('Cartalyst\Sentinel\Sentinel');
        $this->redirect   = m::mock('Illuminate\Routing\Redirector');
        $this->request    = m::mock('EverestBill\Http\Requests\RegistrationData');
        $this->userDomain = m::mock('EverestBill\Domains\User');

        $this->register = new Register();
    }

    public function test_getForm_WhenCalled_ReturnViewInstance()
    {
        $this->view->shouldReceive('make')->andReturn(new stdClass);

        $viewInstance = $this->register->getForm($this->view);

        $this->assertTrue(is_object($viewInstance));
    }

    public function test_perform_WhenCalledAndCustomerFlowIsInSession_ReturnRedirectInstance()
    {
        $this->role         = m::mock();
        $this->customerFlow = m::mock('EverestBill\Domains\CustomerFlow');
        $this->user         = m::mock('Cartalyst\Sentinel\Users\UserInterface');

        $this->role->shouldReceive('users')->andReturnSelf();
        $this->role->shouldReceive('attach');

        $this->request->shouldReceive('all')->andReturn(true);
        $this->userDomain->shouldReceive('register')->andReturn($this->user);
        $this->auth->shouldReceive('findRoleById')->andReturn($this->role);
        $this->auth->shouldReceive('login');

        $this->customerFlow->shouldReceive('isInSession')->andReturn(true);

        $this->redirect->shouldReceive('route')->andReturnSelf();

        $this->redirect
            ->shouldReceive('withSuccess')
            ->andReturnUsing(function ($message) {
                $this->redirect->message = $message;
                return $this->redirect;
            });

        $redirectInstance = $this->register->postData(
            $this->auth,
            $this->userDomain,
            $this->redirect,
            $this->request,
            $this->customerFlow
        );

        $this->assertTrue(is_object($redirectInstance));
        $this->assertTrue(is_string($redirectInstance->message));
    }

    public function test_perform_WhenCalledAndCustomerFlowIsNotInSession_ReturnRedirectInstance()
    {
        $this->role         = m::mock();
        $this->customerFlow = m::mock('EverestBill\Domains\CustomerFlow');
        $this->user         = m::mock('Cartalyst\Sentinel\Users\UserInterface');

        $this->role->shouldReceive('users')->andReturnSelf();
        $this->role->shouldReceive('attach');

        $this->request->shouldReceive('all')->andReturn(true);
        $this->userDomain->shouldReceive('register')->andReturn($this->user);
        $this->auth->shouldReceive('findRoleById')->andReturn($this->role);
        $this->auth->shouldReceive('login');

        $this->customerFlow->shouldReceive('isInSession')->andReturn(false);

        $this->redirect->shouldReceive('route')->andReturnSelf();

        $this->redirect
            ->shouldReceive('withSuccess')
            ->andReturnUsing(function ($message) {
                $this->redirect->message = $message;
                return $this->redirect;
            });

        $redirectInstance = $this->register->postData(
            $this->auth,
            $this->userDomain,
            $this->redirect,
            $this->request,
            $this->customerFlow
        );

        $this->assertTrue(is_object($redirectInstance));
        $this->assertTrue(is_string($redirectInstance->message));
    }

    /**
     * @group testing
     */
    public function test_perform_WhenCalledAndExceptionThrown_ReturnRedirectInstance()
    {
        $this->customerFlow = m::mock('EverestBill\Domains\CustomerFlow');

        $this->userDomain
            ->shouldReceive('register')
            ->andReturnUsing(function() {
                throw new Exception();
            });

        $this->redirect->shouldReceive('back')->andReturnSelf();
        $this->redirect->shouldReceive('withInput')->andReturnSelf();

        $this->redirect
            ->shouldReceive('withError')
            ->andReturnUsing(function ($message) {
                $this->redirect->message = $message;
                return $this->redirect;
            });

        $redirectInstance = $this->register->postData(
            $this->auth,
            $this->userDomain,
            $this->redirect,
            $this->request,
            $this->customerFlow
        );

        $this->assertTrue(is_object($redirectInstance));
        $this->assertTrue(is_string($redirectInstance->message));
    }
}