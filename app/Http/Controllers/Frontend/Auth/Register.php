<?php

namespace EverestBill\Http\Controllers\Frontend\Auth;

use Exception;
use EverestBill\Domains\Order;
use Illuminate\Session\SessionManager;
use Illuminate\View\Factory as View;
use EverestBill\Domains\CustomerFlow;
use Cartalyst\Sentinel\Sentinel as Auth;
use EverestBill\Domains\User as UserDomain;
use EverestBill\Http\Controllers\Controller;
use Illuminate\Routing\Redirector as Redirect;
use EverestBill\Http\Requests\RegistrationData;
use EverestBill\Repositories\User as UserRepository;
use Cartalyst\Sentinel\Activations\IlluminateActivationRepository as Activation;

class Register extends Controller
{
    /**
     * Show the register form
     *
     * @param View $view
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function getForm(View $view)
    {
        return $view->make('frontend.register');
    }

    /**
     * Perform the register request
     *
     * @param Auth             $auth
     * @param UserDomain       $user
     * @param Redirect         $redirect
     * @param Order            $orderDomain
     * @param SessionManager   $session
     * @param RegistrationData $request
     * @param CustomerFlow     $customerFlow
     *
     * @return mixed
     */
    public function perform(
        Auth $auth,
        UserDomain $user,
        Redirect $redirect,
        Order $orderDomain,
        SessionManager $session,
        RegistrationData $request,
        CustomerFlow $customerFlow
    )
    {
        try {
            $user = $user->register($request->all());

            $role = $auth->findRoleById(4);

            $role->users()->attach($user);

            $auth->login($user);

            if ($customerFlow->isInSession()) {
                $message = '
                    Thanks! You are now registered and logged in. 
                    Please continue with the checkout.
                ';

                $data = [
                    'user_id'          => $user->id,
                    'plan_id'          => $session->get('plan_id'),
                    'domain_name'      => $session->get('domain_name'),
                    'domain_extension' => $session->get('domain_extension'),
                    'billing_cycle'    => $session->get('billing_cycle'),
                ];

                $orderDomain->saveSessionItemsToDatabase($data);
            } else {
                $message = '
                    Thanks! You are now registered.
                ';
            }

            return $redirect
                ->route('dashboard.customer_flow.payment')
                ->withSuccess($message);

        } catch (Exception $e) {
            return $redirect
                ->back()
                ->withInput()
                ->withError($e->getMessage());
        }
    }

    /**
     * Activate the user
     *
     * @param            $code
     * @param Redirect   $redirect
     * @param UserDomain $userDomain
     * @param Activation $activation
     *
     * @return mixed
     */
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
        } catch (Exception $e) {
            return $redirect
                ->back()
                ->withInput()
                ->withError('Sorry, but the activation was not successful. Please try again.');
        }
    }

    /**
     * Complete the checkout process
     *
     * @param                $code
     * @param Redirect       $redirect
     * @param UserDomain     $userDomain
     * @param Activation     $activation
     * @param UserRepository $userRepository
     *
     * @return mixed
     */
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
        } catch (Exception $e) {
            return $redirect
                ->back()
                ->withInput()
                ->withError('Sorry, but the activation was not successful. Please try again.');
        }
    }
}
