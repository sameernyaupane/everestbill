<?php

namespace EverestBill\Http\Controllers\Frontend\Auth;

use Exception;
use EverestBill\Domains\User as UserDomain;
use Illuminate\View\Factory as View;
use EverestBill\Http\Controllers\Controller;
use EverestBill\Http\Requests\RegistrationData;
use Illuminate\Routing\Redirector as Redirect;

class Register extends Controller
{
    public function getForm(View $view)
    {
        return $view->make('frontend.register');
    }
    
    public function postData(
        RegistrationData $request, 
        UserDomain $user,
        Redirect $redirect
    )
    {
        try {
            $user->register($request->all()); 
            return $redirect
                ->route('frontend.index')
                ->withSuccess('Registration complete.');
        } catch(Exception $e) {
            return $redirect
            ->back()
            ->withInput()
            ->withError($e->getMessage());
        }      
    }
}
