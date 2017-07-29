<?php

namespace Tests\Unit\Http\Controllers\Backend;

use Mockery as m;
use EverestBill\Http\Controllers\Backend\Dashboard;

class DashboardTest extends \PHPUnit\Framework\TestCase
{
    public function setUp()
    {
        $this->view = m::mock('Illuminate\View\Factory');

        $this->dashboard = new Dashboard();
    }

    public function test_index_WhenCalled_ReturnViewInstance()
    {
        $this->view->shouldReceive('make')->andReturnSelf();

        $view = $this->dashboard->index($this->view);

        $this->assertTrue(is_object($view));
        $this->assertInstanceOf('Illuminate\View\Factory', $view);
    }
}