<?php

namespace Tests\Unit\Http\Controllers\Backend;

use Mockery as m;
use PHPUnit\Framework\TestCase;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use EverestBill\Http\Controllers\Backend\Domain;

class DomainTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    public function setUp()
    {
        $this->view = m::mock('Illuminate\View\Factory');

        $this->domain = new Domain;
    }

    public function test_index_WhenCalled_ReturnViewInstance()
    {
        $domainNameDomain = m::mock('EverestBill\Domains\DomainName');

        $this->view->shouldReceive('make')->andReturnSelf()->once();
        $domainNameDomain->shouldReceive('getAll')->andReturnSelf()->once();
        
        $view = $this->domain->index($this->view, $domainNameDomain);

        $this->assertTrue(is_object($view));
        $this->assertInstanceOf('Illuminate\View\Factory', $view);
    }
}