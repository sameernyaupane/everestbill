<?php

namespace Tests\Integration\Domains;

use Tests\TestCase;
use Tests\MailTracking;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
    use DatabaseTransactions;
    use MailTracking;

    /**
     * @var \EverestBill\Domains\User
     */
    private $userDomain;

    public function setUp()
    {
        parent::setUp();

        $this->userDomain = $this->app->make('EverestBill\Domains\User');
    }

    /**
     * @group testing
     */
    public function test_register_WhenCalled_ShouldFireEvent()
    {
        $data = ['email' => 'test@test.com', 'password' => 'test123'];

        $this->userDomain->register($data);

        $this->seeEmailWasSent(2)
            ->seeEmailSubject('Activation')
            ->seeEmailTo('test@test.com')
            ->seeEmailContains('Activate your account');
    }
}