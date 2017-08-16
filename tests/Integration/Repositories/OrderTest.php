<?php

namespace Tests\Integration\Repositories;

use DB;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class OrderTest extends \Tests\TestCase
{
    use DatabaseTransactions;

    public function setUp()
    {
        parent::setUp();

        $this->order = $this->app->make('EverestBill\Repositories\Order');
    }

    public function test_save_WhenCalledWithRequiredData_SavePlanToDatabase()
    {
        /**
         * Insert needed rows
         *
         */

        DB::table('users')->insert(
            [
                'id'       => 1,
                'email'    => 'test@admin.com',
                'password' => 'test123'
            ]
        );

        DB::table('plans')->insert(
            [
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
            ]
        );

        DB::table('domains')->insert(
            [
                'id'        => 1,
                'user_id'   => 1,
                'name'      => 'test',
                'extension' => 'com'
            ]
        );

        $data = [
            'user_id'       => 1,
            'plan_id'       => 1,
            'domain_id'     => 1,
            'billing_cycle' => 'Monthly',
            'status'        => 'Pending'
        ];

        $this->order->create($data);

        $this->seeInDatabase('orders', [
            'user_id'       => $data['user_id'],
            'plan_id'       => $data['plan_id'],
            'domain_id'     => $data['domain_id'],
            'billing_cycle' => $data['billing_cycle'],
        ]);
    }
}