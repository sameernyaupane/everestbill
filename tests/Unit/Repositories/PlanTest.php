<?php
namespace Tests\Unit\Repositories;

use Exception;
use Mockery as m;
use EverestBill\Repositories\Plan;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;

/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class PlanTest extends \PHPUnit\Framework\TestCase
{
    use MockeryPHPUnitIntegration;

    public function setUp()
    {
        $this->planModel = m::mock('EverestBill\Models\Plan');

        $this->planRepository = new Plan($this->planModel);
    }

    public function test_save_WhenCalledButDatabaseHasIssue_ThrowAnException()
    {
        $this->planModel->shouldReceive('save')
            ->andReturn(false)->once();

        $this->planModel->shouldReceive('setAttribute')
            ->andReturn(true);

        $this->expectException(Exception::class);

        $data = [
            'plan_name'               => 'Starter Package',
            'disk_space'              => 10,
            'disk_unit'               => 'GB',
            'disk_unlimited'          => false,
            'bandwidth'               => 100,
            'bandwidth_unit'          => 'GB',
            'bandwidth_unlimited'     => false,
            'addon_domains'           => 1,
            'addon_domains_unlimited' => 1,
        ];

        $this->planRepository->save((object)$data);
    }
}