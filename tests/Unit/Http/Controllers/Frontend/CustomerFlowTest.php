<?php

namespace Tests\Unit\Http\Controllers\Frontend;

use stdClass;
use Mockery as m;
use EverestBill\Http\Controllers\Frontend\CustomerFlow;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;

class CustomerFlowTest extends \PHPUnit\Framework\TestCase
{
    use MockeryPHPUnitIntegration;

    public function setUp()
    {
        $this->view           = m::mock('Illuminate\View\Factory');
        $this->request        = m::mock('Illuminate\Http\Request');
        $this->planDomain     = m::mock('EverestBill\Domains\Plan');
        $this->redirector     = m::mock('Illuminate\Routing\Redirector');
        $this->sessionManager = m::mock('Illuminate\Session\SessionManager');

        $this->customerFlow = new CustomerFlow();
    }

    public function test_addPlan_WhenCalled_ReturnRedirectorInstance()
    {
        $this->request->plan_id = 1;
        $this->sessionManager->shouldReceive('put');
        $this->redirector->shouldReceive('route')->andReturn(new stdClass)->once();

        $viewInstance = $this->customerFlow->addPlan($this->request, $this->sessionManager, $this->redirector);

        $this->assertTrue(is_object($viewInstance));
    }

    public function test_getAddDomain_WhenCalled_ReturnViewInstance()
    {
        $this->view->shouldReceive('make')->andReturn(new stdClass)->once();

        $viewInstance = $this->customerFlow->getAddDomain($this->view);

        $this->assertTrue(is_object($viewInstance));
    }

    public function test_addDomain_WhenCalled_ReturnRedirectorInstance()
    {
        $this->request->domain_name = 'test';
        $this->request->domain_extension = 'com';
        $this->sessionManager->shouldReceive('put');
        $this->redirector->shouldReceive('route')->andReturn(new stdClass)->once();

        $viewInstance = $this->customerFlow->addDomain($this->request, $this->sessionManager, $this->redirector);

        $this->assertTrue(is_object($viewInstance));
    }

    public function test_getLoginRegister_WhenCalled_ReturnViewInstance()
    {
        $this->view->shouldReceive('make')->andReturn(new stdClass)->once();

        $viewInstance = $this->customerFlow->getLoginRegister($this->view);

        $this->assertTrue(is_object($viewInstance));
    }

    public function test_getChooseBillingCycleView_WhenCalled_ReturnViewInstance()
    {
        $planModelInstance = new stdClass();

        $this->view->shouldReceive('make')->andReturn(new stdClass)->once();
        $this->sessionManager->shouldReceive('get')->andReturn(1)->once();
        $this->planDomain->shouldReceive('getById')->andReturn($planModelInstance)->once();

        $viewInstance = $this->customerFlow->getChooseBillingCycleView($this->view, $this->sessionManager, $this->planDomain);

        $this->assertTrue(is_object($viewInstance));
    }

    public function test_chooseBillingCycle_WhenCalled_ReturnRedirectorInstance()
    {
        $this->request->billing_cycle = 'monthly';
        $this->sessionManager->shouldReceive('put');
        $this->redirector->shouldReceive('route');

        $result = $this->customerFlow->chooseBillingCycle($this->request, $this->sessionManager, $this->redirector);
    }
}