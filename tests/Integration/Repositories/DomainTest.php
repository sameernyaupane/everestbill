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
                'id'       => 1,
                'email'    => 'test@admin.com',
                'password' => 'test123'
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

    public function test_getAll_WhenCalled_GetAllPlansFromDatabase()
    {
        // Insert needed row
        DB::table('users')->insert(
            [
                'id'       => 1,
                'email'    => 'test@admin.com',
                'password' => 'test123'
            ]
        );

        DB::table('domains')->insert([
            [
                'user_id'   => 1,
                'name'      => 'everestbill',
                'extension' => 'com',
            ],
            [
                'user_id'   => 1,
                'name'      => 'sameernyaupane',
                'extension' => 'com',
            ]
        ]);

        $domains = $this->domain->getAll();

        $this->assertEquals(2, $domains->count());

        foreach ($domains as $domain) {
            $this->assertArrayHasKey('name', $domain);
            $this->assertArrayHasKey('extension', $domain);
        }
    }
}