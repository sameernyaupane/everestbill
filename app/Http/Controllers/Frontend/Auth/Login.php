<?php

namespace EverestBill\Http\Controllers\Frontend\Auth;

use Exception;
use Cartalyst\Sentinel\Sentinel;
use Illuminate\View\Factory as View;
use EverestBill\Http\Requests\LoginData;
use EverestBill\Http\Controllers\Controller;
use Illuminate\Routing\Redirector as Redirect;

class Login extends Controller
{
    public function getForm(View $view)
    {
        return $view->make('frontend.login');
    }
    
    public function postData(
        LoginData $request,
        Sentinel $sentinel,
        Redirect $redirect
    )
    {
        try {
            if($user = $sentinel->authenticate($request->all())) {
                return $redirect
                    ->intended()
                    ->withSuccess('Login successful.');
            } else {
                throw new Exception(
                    'An error occured while registering. Please try again.'
                );
            }
        } catch(Exception $e) {
            return $redirect
                ->back()
                ->withInput()
                ->withError($e->getMessage());
        } 
    }
}
