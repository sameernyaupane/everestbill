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
                'id'         => 1,
                'email'      => 'test@admin.com',
                'password'   => 'test123'
            ]
        );

        $user = $this->auth->findById(1);

        $this->user->loginByInstance($user);

        $loggedInUser = $this->auth->getUser();

        $this->assertTrue(is_object($loggedInUser));
        $this->assertEquals($user->id, $loggedInUser->id);
        $this->assertEquals($user->email, $loggedInUser->email);
    }
}