<?php

namespace EverestBill\Adapters;

use EverestBill\Translators\Paypal as PaypalTranslator;

class Paypal
{
    /**
     * Paypal constructor.
     *
     * @param PaypalTranslator $translator
     */
    public function __construct(PaypalTranslator $translator)
    {
        $this->translator = $translator;
    }

    /**
     * Authenticate the institution
     *
     * @return object
     */
    public function getAccessToken()
    {
        $response = $this->translator->postCurlFormData('/oauth2/token', [
            'grant_type' => 'client_credentials',
        ]);

        $decodedBody = json_decode($response);

        return $decodedBody;
    }

    /**
     * Create payment
     *
     * @param array $data
     *
     * @return mixed
     */
    public function createPayment($data)
    {
        $requestData = '{
          "intent": "sale",
          "redirect_urls":
          {
            "return_url": "http://test.com/r",
            "cancel_url": "http://test.com"
          },
          "payer":
          {
            "payment_method": "paypal"
          },
          "transactions": [
          {
            "amount":
            {
              "total": "'. $data['amount'] .'",
              "currency": "USD"
            },
            "item_list":
            {
              "items": [
                {
                    "quantity": "1",
                    "name": "'. $data['planName'] .'",
                    "price": "'. $data['amount'] .'",
                    "currency": "USD",
                    "description": "Shared Hosting"
                }
              ]
            },
            "description": "The payment transaction description.",
            "invoice_number": "merchant invoice",
            "custom": "merchant custom data"
          }]
        }';

        $response = $this->translator->postCurlJson(
            '/payments/payment',
            $requestData,
            $data['accessToken']
        );

        $decodedBody = json_decode($response);

        return $decodedBody;
    }

    /**
     * Execute payment
     *
     * @param integer $accessToken
     * @param array $data
     *
     * @return mixed
     */
    public function executePayment($accessToken, $data)
    {
        $requestData = [
            'payer_id' => $data['payer_id']
        ];

        $response = $this->translator->postCurlJson(
            '/payments/payment/' . $data['payment_id'] . '/execute',
            json_encode($requestData),
            $accessToken
        );

        $decodedBody = json_decode($response);

        return $decodedBody;
    }
}