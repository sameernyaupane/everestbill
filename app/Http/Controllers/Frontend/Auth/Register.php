<?php
namespace EverestBill\Http\Controllers\Frontend\Auth;

use Exception;
use Illuminate\View\Factory as View;
use EverestBill\Domains\CustomerFlow;
use Illuminate\Session\SessionManager;
use EverestBill\Domains\User as UserDomain;
use EverestBill\Http\Controllers\Controller;
use Illuminate\Routing\Redirector as Redirect;
use EverestBill\Http\Requests\RegistrationData;
use EverestBill\Repositories\User as UserRepository;
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
        Redirect $redirect,
        CustomerFlow $customerFlow
    )
    {
        try {
            $user->register($request->all()); 

            if ($customerFlow->isInSession()) {
                $message = '
                    Thanks! You are now registered. 
                    Please check your email for a link to complete your order.
                ';
            } else {
                $message = '
                    Thanks! You are now registered. 
                    Please check your email to activate your account.
                ';
            }

            return $redirect
                ->route('frontend.index')
                ->withSuccess($message);

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

    public function completeCheckout(
        $code, 
        Redirect $redirect, 
        UserDomain $userDomain, 
        Activation $activation,
        UserRepository $userRepository
    )
    {
        try {
            $user = $userDomain->findByActivationCode($code);
            $activation->complete($user, $code);

            $userRepository->loginByInstance($user);

            return $redirect
                ->route('dashboard.complete_checkout')
                ->withSuccess('
                    Awesome! Please continue with your checkout.');
        } catch(Exception $e) {
            dd($e->getMessage());
            return $redirect
                ->back()
                ->withInput()
                ->withError('Sorry, but the activation was not successful. Please try again.');
        } 
    }
}
