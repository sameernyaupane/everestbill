<?php

namespace Tests\Unit\Domains;

use Mockery as m;
use EverestBill\Domains\Order;
use PHPUnit\Framework\TestCase;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;

class OrderTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    public function setUp()
    {
        $this->domainRepository = m::mock('EverestBill\Repositories\Domain');
        $this->orderRepository = m::mock('EverestBill\Repositories\Order');
        $this->session         = m::mock('Illuminate\Session\SessionManager');

        $this->order = new Order($this->session, $this->orderRepository, $this->domainRepository);
    }

    public function test_saveSessionItemsToDatabase_WhenCalled_ShouldRunWithoutException()
    {
        $this->session->shouldReceive('get')->andReturnUsing(function ($arg) {
            return $arg;
        });

        $data = [
            'plan_id'          => 1,
            'domain_name'      => 'test',
            'domain_extension' => 'com',
        ];

        $this->domainRepository->shouldReceive('create')->once();
        $this->orderRepository->shouldReceive('create')->once();

        $this->order->saveSessionItemsToDatabase($data);
    }
}