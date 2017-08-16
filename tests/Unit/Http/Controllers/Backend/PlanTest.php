<?php

namespace Tests\Unit\Http\Controllers\Backend;

use Mockery as m;
use EverestBill\Http\Controllers\Backend\Plan;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;

class PlanTest extends \PHPUnit\Framework\TestCase
{
    use MockeryPHPUnitIntegration;

    public function setUp()
    {
        $this->view = m::mock('Illuminate\View\Factory');

        $this->plan = new Plan();
    }

    public function test_index_WhenCalled_ReturnViewInstance()
    {
        $this->planDomain = m::mock('EverestBill\Domains\Plan');

        $this->view->shouldReceive('make')->andReturnSelf()->once();
        $this->planDomain->shouldReceive('getAll')->andReturnSelf()->once();

        $view = $this->plan->index($this->view, $this->planDomain);

        $this->assertTrue(is_object($view));
        $this->assertInstanceOf('Illuminate\View\Factory', $view);
    }

    public function test_create_WhenCalled_ReturnViewInstance()
    {
        $this->view->shouldReceive('make')->andReturnSelf()->once();

        $view = $this->plan->create($this->view);

        $this->assertTrue(is_object($view));
        $this->assertInstanceOf('Illuminate\View\Factory', $view);
    }

    public function test_store_WhenCalled_ReturnViewInstance()
    {
        $this->planDomain = m::mock('EverestBill\Domains\Plan');
        $this->request    = m::mock('Illuminate\Http\Request');
        $this->redirect   = m::mock('Illuminate\Routing\Redirector');

        $this->planDomain->shouldReceive('store');
        $this->redirect->shouldReceive('route')->andReturnSelf()->once();

        $this->redirect
            ->shouldReceive('withSuccess')
            ->andReturnUsing(function ($message) {
                $this->redirect->message = $message;
                return $this->redirect;
            });

        $redirectInstance = $this->plan->store($this->request, $this->redirect, $this->planDomain);

        $this->assertTrue(is_object($redirectInstance));
        $this->assertInstanceOf('Illuminate\Routing\Redirector', $redirectInstance);
        $this->assertTrue(is_string($redirectInstance->message));
    }
}