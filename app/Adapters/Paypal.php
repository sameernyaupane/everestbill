<?php
namespace EverestBill\Adapters;

use EverestBill\Translators\Paypal as PaypalTranslator;

class Paypal
{
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
        $response    = $this->translator->postCurlFormData('/oauth2/token', [
            'grant_type' => 'client_credentials',
        ]);

        $decodedBody = json_decode($response);

        return $decodedBody;
    }

    public function createPayment($accessToken)
    {
        $data = '{
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
              "total": "4.00",
              "currency": "USD",
              "details":
              {
                "subtotal": "2.00",
                "tax": "2.00",
              }
            },
            "item_list":
            {
              "items": [
              {
                "quantity": "1",
                "name": "item 1",
                "price": "1",
                "currency": "USD",
                "description": "item 1 description",
                "tax": "1"
              },
              {
                "quantity": "1",
                "name": "item 2",
                "price": "1",
                "currency": "USD",
                "description": "item 2 description",
                "tax": "1"
              }]
            },
            "description": "The payment transaction description.",
            "invoice_number": "merchant invoice",
            "custom": "merchant custom data"
          }]
        }';

        $response = $this->translator->postCurlJson(
            '/payments/payment', 
            $data, 
            $accessToken
        );

        $decodedBody = json_decode($response);

        return $decodedBody;
    }

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