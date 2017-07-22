<?php

namespace Tests\Unit\Domains;

use stdClass;
use Mockery as m;
use EverestBill\Domains\Plan;

class PlanTest extends \PHPUnit\Framework\TestCase
{
    public function setUp()
    {
        $this->planDecorator  = m::mock('EverestBill\Decorators\Plan');
        $this->planRepository = m::mock('EverestBill\Repositories\Plan');

        $this->plan = new Plan($this->planDecorator, $this->planRepository);
    }

    public function test_store_WhenCalled_RunWithoutException()
    {
        $this->planRepository->shouldReceive('save')->andReturn('test');

        $this->plan->store(new stdClass());

        $this->assertTrue(true);
    }

    public function test_getAll_WhenCalled_RunWithoutException()
    {
        $plans = m::mock('Illuminate\Database\Eloquent\Collection');

        $this->planRepository->shouldReceive('getAll')->andReturn($plans);
        $this->planDecorator->shouldReceive('decorate')->andReturn($plans);

        $this->plan->getAll(new stdClass());

        $this->assertTrue(is_object($plans));
    }
}