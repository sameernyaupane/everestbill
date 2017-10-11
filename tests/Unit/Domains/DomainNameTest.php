<?php

namespace Tests\Unit\Domains;

use stdClass;
use Mockery as m;
use EverestBill\Domains\DomainName;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;

class DomainNameTest extends \PHPUnit\Framework\TestCase
{
    use MockeryPHPUnitIntegration;

    public function setUp()
    {
        $this->domainNameDecorator  = m::mock('EverestBill\Decorators\DomainName');
        $this->domainNameRepository = m::mock('EverestBill\Repositories\DomainName');

        $this->domainName = new DomainName($this->domainNameDecorator, $this->domainNameRepository);
    }

    public function test_getAll_WhenCalled_RunWithoutException()
    {
        $domainNames = m::mock('Illuminate\Database\Eloquent\Collection');

        $this->domainNameRepository->shouldReceive('getAll')->andReturn($domainNames)->once();
        $this->domainNameDecorator->shouldReceive('decorateAll')->andReturn($domainNames)->once();

        $domainNamesCollection = $this->domainName->getAll(new stdClass());

        $this->assertTrue(is_object($domainNamesCollection));
    }
}