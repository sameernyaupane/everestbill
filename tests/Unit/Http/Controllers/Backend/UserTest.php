<?php

namespace Tests\Unit\Http\Controllers\Backend;

use Mockery as m;
use EverestBill\Http\Controllers\Backend\User;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;

class UserTest extends \PHPUnit\Framework\TestCase
{
    use MockeryPHPUnitIntegration;

    public function setUp()
    {
        $this->view = m::mock('Illuminate\View\Factory');

        $this->user = new User();
    }

    public function test_index_WhenCalled_ReturnViewInstance()
    {
        $this->userRepository = m::mock('EverestBill\Repositories\User');

        $this->view->shouldReceive('make')->andReturnSelf()->once();
        $this->userRepository->shouldReceive('getAll')->andReturnSelf()->once();

        $view = $this->user->index($this->view, $this->userRepository);

        $this->assertTrue(is_object($view));
        $this->assertInstanceOf('Illuminate\View\Factory', $view);
    }

    public function test_create_WhenCalled_ReturnViewInstance()
    {
        $this->view->shouldReceive('make')->andReturnSelf()->once();

        $view = $this->user->create($this->view);

        $this->assertTrue(is_object($view));
        $this->assertInstanceOf('Illuminate\View\Factory', $view);
    }

    public function test_store_WhenCalled_ReturnViewInstance()
    {
        $this->userDomain = m::mock('EverestBill\Domains\User');
        $this->request    = m::mock('Illuminate\Http\Request');
        $this->redirect   = m::mock('Illuminate\Routing\Redirector');

        $this->userDomain->shouldReceive('store');
        $this->redirect->shouldReceive('route')->andReturnSelf()->once();

        $this->redirect
            ->shouldReceive('withSuccess')
            ->andReturnUsing(function ($message) {
                $this->redirect->message = $message;
                return $this->redirect;
            });

        $redirectInstance = $this->user->store($this->request, $this->redirect, $this->userDomain);

        $this->assertTrue(is_object($redirectInstance));
        $this->assertInstanceOf('Illuminate\Routing\Redirector', $redirectInstance);
        $this->assertTrue(is_string($redirectInstance->message));
    }
}