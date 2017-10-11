<?php
namespace EverestBill\Http\Controllers\Frontend\Auth;

use Exception;
use EverestBill\Domains\Order;
use Illuminate\View\Factory as View;
use EverestBill\Domains\CustomerFlow;
use Illuminate\Session\SessionManager;
use EverestBill\Http\Requests\LoginData;
use Cartalyst\Sentinel\Sentinel as Auth;
use EverestBill\Http\Controllers\Controller;
use Illuminate\Routing\Redirector as Redirect;

class Login extends Controller
{
    /**
     * Get the login form
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
     * Perform the login request
     *
     * @param LoginData $request
     * @param Auth      $auth
     * @param Redirect  $redirect
     *
     * @return mixed
     */
    public function perform(
        LoginData $request,
        Auth $auth,
        Redirect $redirect,
        Order $orderDomain,
        SessionManager $session,
        CustomerFlow $customerFlow
    )
    {
        try {
            if($user = $auth->authenticate($request->all())) {

                if ($customerFlow->isInSession()) {
                    $message = 'Thanks! You are now logged in. 
                        Please continue with the checkout.';

                    $data = [
                        'user_id'          => $user->id,
                        'plan_id'          => $session->get('plan_id'),
                        'domain_name'      => $session->get('domain_name'),
                        'domain_extension' => $session->get('domain_extension'),
                        'billing_cycle'    => $session->get('billing_cycle'),
                    ];

                    $orderDomain->saveSessionItemsToDatabase($data);

                    return $redirect
                        ->route('dashboard.customer_flow.payment')
                        ->withSuccess($message);
                } else {
                    $message = '
                    Thanks! You are now logged in.';

                    return $redirect
                        ->intended()
                        ->withSuccess($message);
                }

            } else {
                throw new Exception(
                    'Login details incorrect. Please try again.'
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
