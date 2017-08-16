<?php

namespace Tests\Unit\Http\Controllers\Frontend;

use stdClass;
use Mockery as m;
use EverestBill\Http\Controllers\Frontend\Auth\Logout;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;

class LogoutTest extends \PHPUnit\Framework\TestCase
{
    use MockeryPHPUnitIntegration;

    public function setUp()
    {
        $this->view     = m::mock('Illuminate\View\Factory');
        $this->auth     = m::mock('Cartalyst\Sentinel\Sentinel');
        $this->redirect = m::mock('Illuminate\Routing\Redirector');
        $this->request  = m::mock('EverestBill\Http\Requests\LoginData');

        $this->logout = new Logout();
    }

    public function test_getForm_WhenCalled_ReturnViewInstance()
    {
        $this->view->shouldReceive('make')->andReturn(new stdClass)->once();

        $viewInstance = $this->logout->getForm($this->view);

        $this->assertTrue(is_object($viewInstance));
    }

    public function test_perform_WhenCalled_ReturnRedirectInstance()
    {
        $this->auth->shouldReceive('logout')->andReturn(true)->once();
        $this->redirect->shouldReceive('intended')->andReturnSelf()->once();

        $this->redirect
            ->shouldReceive('withSuccess')
            ->andReturnUsing(function($message) {
                $this->redirect->message = $message;
                return $this->redirect;
            });

        $redirectInstance = $this->logout->perform(
            $this->auth,
            $this->redirect
        );

        $this->assertTrue(is_object($redirectInstance));
        $this->assertTrue(is_string($redirectInstance->message));
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

        $this->auth->shouldReceive('logout')->andReturn(false)->once();
        $this->redirect->shouldReceive('back')->andReturnSelf()->once();

        $redirectInstance = $this->logout->perform(
            $this->auth,
            $this->redirect
        );

        $this->assertTrue(is_object($redirectInstance));
        $this->assertTrue(is_string($redirectInstance->message));
    }
}