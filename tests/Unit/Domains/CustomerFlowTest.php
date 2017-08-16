<?php

namespace Tests\Unit\Domains;

use stdClass;
use Mockery as m;
use EverestBill\Domains\CustomerFlow;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;

class CustomerFlowTest extends \PHPUnit\Framework\TestCase
{
    use MockeryPHPUnitIntegration;

    public function setUp()
    {
        $this->session  = m::mock('Illuminate\Session\SessionManager');

        $this->customerFLow = new CustomerFlow($this->session);
    }

    public function test_getAll_WhenCalled_ReturnTrue()
    {
        $this->session->shouldReceive('has')->andReturn(true)->times(3);

        $boolean = $this->customerFLow->isInSession();

        $this->assertTrue($boolean);
    }

    public function test_getAll_WhenCalledAndVariablesNotInSession_ReturnFalse()
    {
        $this->session->shouldReceive('has')->andReturn(false)->once();

        $boolean = $this->customerFLow->isInSession();

        $this->assertFalse($boolean);
    }
}