<?php

namespace EverestBill\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \EverestBill\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \EverestBill\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            'throttle:60,1',
            'bindings',
        ],

        'admin' => [
            'checkIfLoggedIn',
            'checkifAdmin'
        ]
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'checkIfLoggedIn' => \EverestBill\Http\Middleware\CheckIfLoggedIn::class,
        'checkifAdmin'    => \EverestBill\Http\Middleware\CheckIfAdmin::class,
        'auth.basic'      => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'bindings'        => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'can'             => \Illuminate\Auth\Middleware\Authorize::class,
        'guest'           => \EverestBill\Http\Middleware\RedirectIfAuthenticated::class,
        'throttle'        => \Illuminate\Routing\Middleware\ThrottleRequests::class,
    ];
}
