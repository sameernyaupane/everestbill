<?php

namespace EverestBill\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'user-registered' => [
            'EverestBill\Listeners\SendWelcomeEmail',
            'EverestBill\Listeners\SendActivationEmail',
        ],
        'EverestBill\Events\UserRegisteredThroughCustomerFlow' => [
            'EverestBill\Listeners\SendWelcomeEmail',
            'EverestBill\Listeners\SendCompleteCheckoutEmail',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
