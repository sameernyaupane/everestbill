<?php
namespace Tests\Integration\Repositories;

use DB;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PlanTest extends \Tests\TestCase
{
    //use DatabaseTransactions;

    public function setUp()
    {
        parent::setUp();

        $this->plan = $this->app->make('EverestBill\Repositories\Plan');
    }

    public function test_save_WhenCalledWithRequiredData_SavePlanToDatabase()
    {
        $data = (object)[
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

        $this->plan->save($data);

        $this->seeInDatabase('plans', [
            'plan_name'               => 'Starter Package',
            'disk_space'              => 10,
            'disk_unit'               => 'GB',
            'disk_unlimited'          => false,
            'bandwidth'               => 100,
            'bandwidth_unit'          => 'GB',
            'bandwidth_unlimited'     => false,
            'addon_domains'           => 1,
            'addon_domains_unlimited' => 1,
        ]);
    }

    /**
     * @group testing
     */
    public function test_getAll_WhenCalled_GetAllPlansFromDatabase()
    {
        DB::table('plans')->insert([
            [
                'plan_name'               => 'Starter Package',
                'disk_space'              => 10,
                'disk_unit'               => 'GB',
                'disk_unlimited'          => false,
                'bandwidth'               => 100,
                'bandwidth_unit'          => 'GB',
                'bandwidth_unlimited'     => false,
                'addon_domains'           => 1,
                'addon_domains_unlimited' => 1,
            ],
            [
                'plan_name'               => 'Professional Package',
                'disk_space'              => 10,
                'disk_unit'               => 'GB',
                'disk_unlimited'          => false,
                'bandwidth'               => 100,
                'bandwidth_unit'          => 'GB',
                'bandwidth_unlimited'     => false,
                'addon_domains'           => 1,
                'addon_domains_unlimited' => 1,
            ]
        ]);

        $plans = $this->plan->getAll();

        $this->assertEquals(2, $plans->count());

        foreach ($plans as $plan) {
            $this->assertArrayHasKey('plan_name', $plan);
            $this->assertArrayHasKey('disk_space', $plan);
            $this->assertArrayHasKey('disk_unit', $plan);
            $this->assertArrayHasKey('disk_unlimited', $plan);
            $this->assertArrayHasKey('bandwidth', $plan);
            $this->assertArrayHasKey('bandwidth_unit', $plan);
            $this->assertArrayHasKey('bandwidth_unlimited', $plan);
            $this->assertArrayHasKey('addon_domains', $plan);
            $this->assertArrayHasKey('addon_domains_unlimited', $plan);
        }
    }
}