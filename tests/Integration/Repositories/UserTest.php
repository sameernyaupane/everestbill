<?php

namespace Tests\Integration\Repositories;

use DB;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends \Tests\TestCase
{
    use DatabaseTransactions;

    public function setUp()
    {
        parent::setUp();

        $this->user = $this->app->make('EverestBill\Repositories\User');
        $this->auth = $this->app->make('Cartalyst\Sentinel\Sentinel');
    }

    public function test_getAll_WhenCalled_ReturnAllUsers()
    {
        $users = $this->user->getAll();

        $this->assertTrue(is_object($users));
    }

    public function test_loginByInstance_WhenCalled_ReturnAllUsers()
    {
        // Insert needed row
        DB::table('users')->insert(
            [
                'id'       => 1,
                'email'    => 'test@admin.com',
                'password' => 'test123'
            ]
        );

        $user = $this->auth->findById(1);

        $this->user->loginByInstance($user);

        $loggedInUser = $this->auth->getUser();

        $this->assertTrue(is_object($loggedInUser));
        $this->assertEquals($user->id, $loggedInUser->id);
        $this->assertEquals($user->email, $loggedInUser->email);
    }

    public function test_getLatestOrder_WhenCalled_ReturnLatestOrderAmount()
    {
        /**
         * Insert needed rows
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

        $pricing = [
            'id'            => 1,
            'plan_id'       => 1,
            'monthly_price' => 4,
            'yearly_price'  => 16,
        ];

        DB::table('pricing')->insert($pricing);

        DB::table('domains')->insert(
            [
                'id'        => 1,
                'user_id'   => 1,
                'name'      => 'test',
                'extension' => 'com'
            ]
        );

        DB::table('orders')->insert(
            [
                'id'            => 1,
                'user_id'       => 1,
                'plan_id'       => 1,
                'domain_id'     => 1,
                'billing_cycle' => 'monthly',
                'status'        => 'Pending',
            ]
        );

        $user = $this->auth->findById(1);

        $this->user->loginByInstance($user);

        $latestOrder = $this->user->getLatestOrder();

        $this->assertTrue(is_object($latestOrder));
        $this->assertEquals($latestOrder->amount, $pricing['monthly_price']);
    }
}