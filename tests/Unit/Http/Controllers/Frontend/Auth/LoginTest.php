<?php

namespace Tests\Unit\Http\Controllers\Frontend;

use stdClass;
use Mockery as m;
use EverestBill\Http\Controllers\Frontend\Auth\Login;

class LoginTest extends \PHPUnit\Framework\TestCase
{
    public function setUp()
    {
        $this->view     = m::mock('Illuminate\View\Factory');
        $this->auth     = m::mock('Cartalyst\Sentinel\Sentinel');
        $this->redirect = m::mock('Illuminate\Routing\Redirector');
        $this->request  = m::mock('EverestBill\Http\Requests\LoginData');

        $this->login = new Login();
    }

    public function test_getForm_WhenCalled_ReturnViewInstance()
    {
        $this->view->shouldReceive('make')->andReturn(new stdClass);

        $viewInstance = $this->login->getForm($this->view);

        $this->assertTrue(is_object($viewInstance));
    }

    public function test_postData_WhenCalled_ReturnRedirectInstance()
    {
        $passedObject = m::mock();

        $passedObject
            ->shouldReceive('withSuccess')
            ->andReturn(new stdClass);

        $this->request->shouldReceive('all')->andReturn(true);
        $this->auth->shouldReceive('authenticate')->andReturn(true);
        $this->redirect->shouldReceive('intended')->andReturn($passedObject);

        $redirectInstance = $this->login->postData(
            $this->request,
            $this->auth,
            $this->redirect
        );

        $this->assertTrue(is_object($redirectInstance));
    }

    public function test_postData_WhenCalledButAuthenticationFailed_ReturnRedirectInstance()
    {
        $this->redirect
            ->shouldReceive('withInput')
            ->andReturnSelf();

        $this->redirect
            ->shouldReceive('withError')
            ->andReturnUsing(function($message) {
                $this->redirect->message = $message;
                return $this->redirect;
            });

        $this->request->shouldReceive('all')->andReturn(true);
        $this->auth->shouldReceive('authenticate')->andReturn(false);
        $this->redirect->shouldReceive('back')->andReturnSelf();

        $redirectInstance = $this->login->postData(
            $this->request,
            $this->auth,
            $this->redirect
        );

        $this->assertTrue(is_object($redirectInstance));
        $this->assertTrue(is_string($redirectInstance->message));
    }
}