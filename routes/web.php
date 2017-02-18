<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

/**
 * Register Frontend Routes
 */
$router->group(['namespace' => 'Frontend'], function ($router) {

    $router->get('/', function () {
        return view('frontend.index');
    })->name('frontend.index');

    // Auth Routes
    $router->group(['namespace' => 'Auth'], function ($router) {
        $router->get('login', 'Login@getForm')->name('login.index');
        $router->post('login', 'Login@postData');
        $router->get('register', 'Register@getForm')->name('register.index');
        $router->post('register', 'Register@postData');
        $router->get('activate/{code}', 'Register@activate')->name('register.activate');
    });

});

$router->get('test', function() {
    $user = EverestBill\Models\User::find(12);
    dd($user->activations);
});