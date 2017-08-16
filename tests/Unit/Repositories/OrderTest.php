<?php

namespace Tests\Unit\Repositories;

use Exception;
use Mockery as m;
use PHPUnit\Framework\TestCase;
use EverestBill\Repositories\Order;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;

/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class OrderTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    public function setUp()
    {
        $this->orderModel = m::mock('EverestBill\Models\Order');

        $this->orderRepository = new Order($this->orderModel);
    }

    public function test_create_WhenCalledButDatabaseHasIssue_ThrowAnException()
    {
        $this->orderModel->shouldReceive('save')
            ->andReturn(false)->once();

        $this->orderModel->shouldReceive('setAttribute')
            ->andReturn(true);

        $this->expectException(Exception::class);

        $data = [
            'user_id'       => 1,
            'plan_id'       => 1,
            'domain_id'     => 1,
            'billing_cycle' => 'Monthly',
            'status'        => 'Pending'
        ];

        $this->orderRepository->create($data);
    }
}