<?php

namespace Tests\Integration\Adapters;

use Tests\TestCase;

class CpanelTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->cpanel = $this->app->make(\EverestBill\Adapters\Cpanel::class);
    }

    public function test_createCpanelAccount_WhenCalled_ShouldReceiveSuccessMessage()
    {
        $response = $this->cpanel->createCpanelAccount();

        $this->assertTrue(is_object($response));
        $this->assertObjectHasAttribute('metadata', $response);

        $this->assertTrue(is_object($response->metadata));
        $this->assertObjectHasAttribute('result', $response->metadata);

        $this->assertEquals(1, $response->metadata->result);
    }
}