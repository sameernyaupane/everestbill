<?php

namespace Tests\Integration\Repositories;

use DB;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DomainTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp()
    {
        parent::setUp();

        $this->domain = $this->app->make('EverestBill\Repositories\Domain');
    }

    public function test_save_WhenCalledWithRequiredData_SavePlanToDatabase()
    {
        // Insert needed row
        DB::table('users')->insert(
            [
                'id'         => 1,
                'email'      => 'test@admin.com',
                'password'   => 'test123'
            ]
        );

        $data = [
            'user_id'          => 1,
            'domain_name'      => 'test',
            'domain_extension' => 'com',
        ];

        $domainId = $this->domain->create($data);

        $this->assertTrue(is_int($domainId));

        $this->seeInDatabase('domains', [
            'name'      => $data['domain_name'],
            'extension' => $data['domain_extension'],
        ]);
    }
}