<?php

namespace EverestBill\Http\Controllers\Frontend\Auth;

use Exception;
use Illuminate\View\Factory as View;
use Cartalyst\Sentinel\Sentinel as Auth;
use EverestBill\Http\Controllers\Controller;
use Illuminate\Routing\Redirector as Redirect;

class Logout extends Controller
{
    /**
     * Show the logout form
     *
     * @param View $view
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function getForm(View $view)
    {
        return $view->make('frontend.login');
    }

    /**
     * Perform logout request
     *
     * @param Auth     $auth
     * @param Redirect $redirect
     *
     * @return mixed
     */
    public function perform(
        Auth $auth,
        Redirect $redirect
    )
    {
        try {
            if($user = $auth->logout()) {
                return $redirect
                    ->intended()
                    ->withSuccess('You have been logged out.');
            } else {
                throw new Exception(
                    'An error occured during the logout process. Please try again.'
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
