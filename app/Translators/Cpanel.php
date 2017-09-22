<?php

namespace EverestBill\Translators;

class Cpanel
{
    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $userName;

    /**
     * @var string
     */
    private $apiToken;

    /**
     * Cpanel Translator constructor.
     */
    public function __construct()
    {
        $this->url      = config('cpanel.url');
        $this->userName = config('cpanel.username');
        $this->apiToken = config('cpanel.apitoken');
    }

    /**
     * Make a get request
     *
     * @param string $uri
     * @param array  $data
     *
     * @return array
     */
    public function get($uri, array $data = [])
    {
        $query = http_build_query($data);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_PORT           => "2087",
            CURLOPT_URL            => $this->url . ':2087/' . $uri . '?' . $query,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING       => "",
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_TIMEOUT        => 30,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => "GET",
            CURLOPT_HTTPHEADER     => array(
                "authorization: whm $this->userName:$this->apiToken",
                "cache-control: no-cache",
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return $response;
    }

}