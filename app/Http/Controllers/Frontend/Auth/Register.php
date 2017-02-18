<?php
namespace EverestBill\Http\Controllers\Frontend\Auth;

use Exception;
use Illuminate\View\Factory as View;
use EverestBill\Domains\User as UserDomain;
use EverestBill\Http\Controllers\Controller;
use Illuminate\Routing\Redirector as Redirect;
use EverestBill\Http\Requests\RegistrationData;
use Cartalyst\Sentinel\Activations\IlluminateActivationRepository as Activation;

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
                ->withSuccess('
                    Thanks! You are now registered. 
                    Please check your email to activate your account.');
        } catch(Exception $e) {
            return $redirect
                ->back()
                ->withInput()
                ->withError($e->getMessage());
        }      
    }

    public function activate(
        $code, 
        Redirect $redirect, 
        UserDomain $userDomain, 
        Activation $activation
    )
    {
        try {
            $user = $userDomain->findByActivationCode($code);
            $activation->complete($user, $code);

            return $redirect
                ->route('frontend.index')
                ->withSuccess('
                    Awesome! You are now activated. You can login now.');
        } catch(Exception $e) {
            return $redirect
                ->back()
                ->withInput()
                ->withError('Sorry, but the activation was not successful. Please try again.');
        } 
    }
}
