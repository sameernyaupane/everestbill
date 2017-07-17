<?php
namespace EverestBill\Providers;

use Illuminate\Routing\Router;
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
    public function boot(Auth $auth, View $view, Router $router)
    {
        $view->composer('*', function ($view) use($auth, $router) {

            $currentRouteName = $router->currentRouteName();

            $navBar = '
            <li class="' . (($currentRouteName == 'frontend.index') ? 'active' : '')  . '">
                <a href="' . route('frontend.index') .'">Home</a>
            </li>
            <li class="' . (($currentRouteName == 'frontend.plans') ? 'active' : '') . '">
                <a href="' . route('frontend.plans') .'">Plans</a>
            </li>
            <li><a href="#about">About</a></li>
            <li><a href="#contact">Contact</a></li>';

            if($user = $auth->check()) {
                $welcomeMessage = 'Welcome, ' . $user->full_name;
                $dropdownMenu = '
                <li><a href="'. route('dashboard.index') .'">Dashboard</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="'. route('logout.perform') .'">Logout</a></li>';
            } else {
                $welcomeMessage = 'Welcome, Guest';
                $dropdownMenu = '
                <li><a href="'. route('login.index') .'">Login</a></li>
                <li><a href="'. route('register.index') .'">Register</a></li>';
            }

            $view
                ->with('navBar', $navBar)
                ->with('welcomeMessage', $welcomeMessage)
                ->with('dropdownMenu', $dropdownMenu);
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