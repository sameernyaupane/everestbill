<?php

namespace Tests\Unit\Http\Controllers\Frontend;

use stdClass;
use Mockery as m;
use EverestBill\Http\Controllers\Frontend\Plan;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;

class PlanTest extends \PHPUnit\Framework\TestCase
{
    use MockeryPHPUnitIntegration;

    public function setUp()
    {
        $this->view       = m::mock('Illuminate\View\Factory');
        $this->planDomain = m::mock('EverestBill\Domains\Plan');

        $this->plan = new Plan();
    }

    public function test_index_WhenCalled_ReturnViewInstance()
    {
        $this->planDomain->shouldReceive('getAll')->andReturn('plans')->once();
        $this->view->shouldReceive('make')->andReturn(new stdClass)->once();

        $viewInstance = $this->plan->index($this->view, $this->planDomain);

        $this->assertTrue(is_object($viewInstance));
    }
}