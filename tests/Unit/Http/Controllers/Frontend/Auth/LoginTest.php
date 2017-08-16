<?php

namespace Tests\Unit\Http\Controllers\Frontend;

use stdClass;
use Mockery as m;
use EverestBill\Http\Controllers\Frontend\Auth\Login;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;

class LoginTest extends \PHPUnit\Framework\TestCase
{
    use MockeryPHPUnitIntegration;

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
        $this->view->shouldReceive('make')->andReturn(new stdClass)->once();

        $viewInstance = $this->login->getForm($this->view);

        $this->assertTrue(is_object($viewInstance));
    }

    public function test_perform_WhenCalled_ReturnRedirectInstance()
    {
        $passedObject = m::mock();

        $passedObject
            ->shouldReceive('withSuccess')
            ->andReturn(new stdClass)->once();

        $this->request->shouldReceive('all')->andReturn(true)->once();
        $this->auth->shouldReceive('authenticate')->andReturn(true)->once();
        $this->redirect->shouldReceive('intended')->andReturn($passedObject)->once();

        $redirectInstance = $this->login->perform(
            $this->request,
            $this->auth,
            $this->redirect
        );

        $this->assertTrue(is_object($redirectInstance));
    }

    public function test_perform_WhenCalledButAuthenticationFailed_ReturnRedirectInstance()
    {
        $this->redirect
            ->shouldReceive('withInput')
            ->andReturnSelf()->once();

        $this->redirect
            ->shouldReceive('withError')
            ->andReturnUsing(function($message) {
                $this->redirect->message = $message;
                return $this->redirect;
            });

        $this->request->shouldReceive('all')->andReturn(true)->once();
        $this->auth->shouldReceive('authenticate')->andReturn(false)->once();
        $this->redirect->shouldReceive('back')->andReturnSelf()->once();

        $redirectInstance = $this->login->perform(
            $this->request,
            $this->auth,
            $this->redirect
        );

        $this->assertTrue(is_object($redirectInstance));
        $this->assertTrue(is_string($redirectInstance->message));
    }
}