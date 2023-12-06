<?php

class PayzeApi
{
    public $apiKey;

    public $apiSecret;

    private $method = 'GET';

    public $webhook = 'http://localhost:8080/webhook.php';

    public $successUrl = 'http://localhost:8080/response.php';

    public $errorUrl = 'http://localhost:8080/response.php';

    public function __construct($apiKey, $apiSecret)
    {
        $this->apiKey = $apiKey;
        $this->apiSecret = $apiSecret;
    }

    public function getPaymentList()
    {
        $this->method = 'GET';
        return $this->request('payment/query/token-based', [
            '$orderby' => 'createdDate desc',
        ]);
    }

//            "cardPayment" => [
//                "tokenizeCard" => true
//            ],
//            "token" => "F9EC9AEF648F4EF7A0B71A5AA",
    public function create($amount)
    {
        $this->method = 'PUT';
        return $this->request('payment', [
            "source" => "Card",
            "amount" => $amount,
            "currency" => "UZS",
            "language" => "UZ",
            "hooks" => [
                "webhookGateway" => $this->webhook,
                "successRedirectGateway" => $this->successUrl,
                "errorRedirectGateway" => $this->errorUrl,
            ]
        ]);
    }


    public function request($action, $options = [])
    {
        $ch = curl_init();
        $extraUrl = "";
        if ($this->method == 'GET') {
            $extraUrl = "?" . http_build_query($options);
        }
        curl_setopt($ch, CURLOPT_URL, 'https://payze.io/v2/api/' . $action . $extraUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $this->method);
        $headers = [];
        $headers[] = 'Authorization: ' . $this->apiKey . ":" . $this->apiSecret;
        if ($this->method == 'PUT') {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($options));
            $headers[] = 'Content-Type: application/json';
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($ch);
        curl_close($ch);

        return json_decode($result, true);
    }
}