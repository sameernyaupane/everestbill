<?php
namespace EverestBill\Providers;

use Cartalyst\Sentinel\Sentinel as Auth;
use Illuminate\View\Factory as View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function boot(Auth $auth, View $view)
    {
        // Using Closure based composers...
        $view->composer('*', function ($view) use($auth) {

            if($user = $auth->check()) {
                $welcomeMessage = 'Welcome, ' . $user->full_name;
            } else {
                $welcomeMessage = 'Welcome, Guest';
            }

            $view->with('welcomeMessage', $welcomeMessage);
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}