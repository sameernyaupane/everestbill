<?php
namespace EverestBill\Translators;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class Paypal
{
    /**
     * Client instance
     *
     * @var Client
     */
    private $client;

    /**
     * Client id
     *
     * @var string
     */
    private $clientId;

    /**
     * Secret
     *
     * @var string
     */
    private $secret;

    /**
     * Plaid constructor.
     */
    public function __construct()
    {
        $this->url      = config('paypal.url');
        $this->clientId = config('paypal.clientId');
        $this->secret   = config('paypal.secret');

        $this->client   = new Client([
            // Base URI is used with relative requests
            'base_uri' => config('paypal.url'),
            // You can set any number of default request options.
            'timeout'  => 10.0,
            'verify'   => false
        ]);
    }

    public function postCurlFormData($uri, $params)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->url . $uri);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_USERPWD, $this->clientId . ':' . $this->secret);

        $headers = [];
        $headers[] = "Accept: application/json";
        $headers[] = "Accept-Language: en_US";
        $headers[] = "Content-Type: application/x-www-form-urlencoded";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }

        curl_close($ch);

        return $response;
    }

    public function postCurlJson($uri, $data, $accessToken = null)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->url . $uri);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_POST, 1);

        $headers = [];
        $headers[] = "Accept: application/json";
        $headers[] = "Accept-Language: en_US";
        $headers[] = "Content-Type: application/json";
        $headers[] = "Authorization: Bearer $accessToken";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }

        curl_close($ch);

        return $response;
    }
}