<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| All of the EverestBill routes are defined here.
|
*/

/**
 * Register Frontend Routes
 */
$router->group(['namespace' => 'Frontend'], function ($router) {

    $router->get('/', function () {
        return view('frontend.index');
    })->name('frontend.index');

    $router->get('plans', 'Plan@index')->name('frontend.plans');
    $router->post('add-plan', 'CustomerFlow@addPlan')->name('customerflow.add.plan');
    $router->get('add-domain', 'CustomerFlow@getAddDomain')->name('customerflow.add.domain');
    $router->post('add-domain', 'CustomerFlow@addDomain');
    $router->get('login-register', 'CustomerFlow@getLoginRegister')->name('customerflow.login.register');

    // Auth Routes
    $router->group(['namespace' => 'Auth'], function () {
        $this->get('login', 'Login@getForm')->name('login.index');
        $this->get('logout', 'Logout@perform')->name('logout.perform');
        $this->post('login', 'Login@postData');
        $this->get('register', 'Register@getForm')->name('register.index');
        $this->post('register', 'Register@postData');
        $this->get('activate/{code}', 'Register@activate')->name('register.activate');
        $this->get('complete-checkout/{code}', 'Register@completeCheckout')->name('register.complete.checkout');
    });

});

/**
 * Register Backend Routes
 */
$router->group(['prefix' => 'dashboard', 'middleware' => 'auth', 'namespace' => 'Backend'], function ($router) {

    $router->get('/', 'Dashboard@index')->name('dashboard.index');

    $router->get('complete-checkout', 'CustomerFlow@completeCheckout')->name('dashboard.complete_checkout');
    $router->get('payment', 'CustomerFlow@payment')->name('dashboard.customer_flow.payment');
    $router->post('create-payment', 'CustomerFlow@createPayment')->name('customer_flow.create-payment');
    $router->post('execute-payment', 'CustomerFlow@executePayment')->name('customer_flow.execute-payment');

    
    $router->resource('plans', 'Plan');
    $router->resource('users', 'User');
    $router->resource('domains', 'User');

    $router->get('checkout/api/paypal/payment/create', 'CustomerFlow@paypalPaymentCreate')->name('customer_flow.paypal_payment.create');
});