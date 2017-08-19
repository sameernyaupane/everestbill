<?php

namespace EverestBill\Http\Controllers\Backend;

use Omnipay\Omnipay;
use Illuminate\Http\Request;
use EverestBill\Adapters\Paypal;
use Illuminate\Routing\Redirector;
use Illuminate\View\Factory as View;
use Illuminate\Session\SessionManager;
use EverestBill\Domains\Plan as PlanDomain;
use EverestBill\Http\Controllers\Controller;
use EverestBill\Repositories\Plan as PlanRepository;
use EverestBill\Repositories\User as UserRepository;
use Illuminate\Contracts\Routing\ResponseFactory as Response;

class CustomerFlow extends Controller
{
    /**
     * Show the payment page
     *
     * @param  View $view
     *
     * @return View
     */
    public function payment(View $view)
    {
        return $view->make('backend.customer_flow.payment');
    }

    /**
     * Create the payment
     *
     * @param  View $view
     *
     * @return View
     */
    public function createPayment(Paypal $paypal, Response $response, UserRepository $userRepository)
    {
        $result = $paypal->getAccessToken();

        $order = $userRepository->getLatestOrder();

        $requestData = [
            'amount'      => $order->amount,
            'planName'    => $order->planName,
            'accessToken' => $result->access_token,
        ];

        $result = $paypal->createPayment($requestData);

        $data = [
            'id' => $result->id
        ];

        return $response->json($data);
    }

    /**
     * Execute the payment
     *
     * @param  View $view
     *
     * @return View
     */
    public function executePayment(Request $request, Paypal $paypal, Response $response)
    {
        $result = $paypal->getAccessToken();

        $result = $paypal->executePayment($result->access_token, $request->all());

        $data = [
            'status' => 'success'
        ];

        return $response->json($data);
    }
}
