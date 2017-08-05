<?php

namespace Tests\Integration\Repositories;

use DB;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PlanTest extends \Tests\TestCase
{
    use DatabaseTransactions;

    public function setUp()
    {
        parent::setUp();

        $this->plan = $this->app->make('EverestBill\Repositories\Plan');
    }

    public function test_save_WhenCalledWithRequiredData_SavePlanToDatabase()
    {
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

        $this->plan->save((object)$data);

        $this->seeInDatabase('plans', [
            'plan_name'               => $data['plan_name'],
            'disk_space'              => $data['disk_space'],
            'disk_unit'               => $data['disk_unit'],
            'bandwidth'               => $data['bandwidth'],
            'addon_domains'           => $data['addon_domains'],
            'addon_domains_unlimited' => $data['addon_domains_unlimited'],
        ]);
    }

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

    /**
     * @group testing
     */
    public function test_getById_WhenCalled_GetPlanFromDatabase()
    {
        DB::table('plans')->insert([
            'id'                      => 1,
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

        $plan = $this->plan->getById(1);

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