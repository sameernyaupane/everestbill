<?php

namespace Tests\Unit\Repositories;

use Exception;
use Mockery as m;
use EverestBill\Repositories\Domain;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;

/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class DomainTest extends \PHPUnit\Framework\TestCase
{
    use MockeryPHPUnitIntegration;

    public function setUp()
    {
        $this->domainModel = m::mock('EverestBill\Models\Domain');

        $this->domainRepository = new Domain($this->domainModel);
    }

    public function test_create_WhenCalledButDatabaseHasIssue_ThrowAnException()
    {
        $this->domainModel->shouldReceive('save')
            ->andReturn(false)->once();

        $this->domainModel->shouldReceive('setAttribute')
            ->andReturn(true);

        $this->expectException(Exception::class);

        $data = [
            'user_id'          => 1,
            'domain_name'      => 'test',
            'domain_extension' => 'com',
        ];

        $this->domainRepository->create($data);
    }
}