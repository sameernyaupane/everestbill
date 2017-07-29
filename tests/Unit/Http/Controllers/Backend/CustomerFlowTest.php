<?php

namespace Tests\Unit\Http\Controllers\Backend;

use Mockery as m;
use EverestBill\Http\Controllers\Backend\CustomerFlow;

class CustomerFlowTest extends \PHPUnit\Framework\TestCase
{
    public function setUp()
    {
        $this->view = m::mock('Illuminate\View\Factory');

        $this->customerFlow = new CustomerFlow();
    }

    public function test_getAddDomain_WhenCalled_ReturnViewInstance()
    {
        $this->view->shouldReceive('make')->andReturnSelf();

        $view = $this->customerFlow->getAddDomain($this->view);

        $this->assertTrue(is_object($view));
        $this->assertInstanceOf('Illuminate\View\Factory', $view);
    }

    public function test_payment_WhenCalled_ReturnViewInstance()
    {
        $this->view->shouldReceive('make')->andReturnSelf();

        $view = $this->customerFlow->payment($this->view);

        $this->assertTrue(is_object($view));
        $this->assertInstanceOf('Illuminate\View\Factory', $view);
    }

    public function test_createPayment_WhenCalled_ReturnResponseInstance()
    {
        $this->resultInstance = m::mock();
        $this->paypal         = m::mock('EverestBill\Adapters\Paypal');
        $this->response       = m::mock('Illuminate\Contracts\Routing\ResponseFactory');

        $this->paypal->shouldReceive('getAccessToken')->andReturn($this->resultInstance);
        $this->paypal->shouldReceive('createPayment')->andReturn($this->resultInstance);

        $this->response->shouldReceive('json')->andReturnSelf();

        $this->resultInstance->id           = 1;
        $this->resultInstance->access_token = 'test_token';

        $response = $this->customerFlow->createPayment($this->paypal, $this->response);

        $this->assertTrue(is_object($response));
        $this->assertInstanceOf('Illuminate\Contracts\Routing\ResponseFactory', $response);
    }

    public function test_executePayment_WhenCalled_ReturnResponseInstance()
    {
        $this->result   = m::mock();
        $this->request  = m::mock('Illuminate\Http\Request');
        $this->paypal   = m::mock('EverestBill\Adapters\Paypal');
        $this->response = m::mock('Illuminate\Contracts\Routing\ResponseFactory');

        $this->paypal->shouldReceive('getAccessToken')->andReturn($this->result);
        $this->paypal->shouldReceive('executePayment')->andReturn($this->result);

        $this->request->shouldReceive('all');
        $this->response->shouldReceive('json')->andReturnSelf();

        $this->result->id           = 1;
        $this->result->access_token = 'test_token';

        $response = $this->customerFlow->executePayment($this->request, $this->paypal, $this->response);

        $this->assertTrue(is_object($response));
        $this->assertInstanceOf('Illuminate\Contracts\Routing\ResponseFactory', $response);
    }
}