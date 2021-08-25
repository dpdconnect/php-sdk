<?php

namespace DpdConnect\Sdk\Resources;

use DpdConnect\Sdk\Common\HttpClient;

/**
 * Class Token
 *
 * @package DpdConnect\Sdk\Resources
 */
class Token
{
    /**
     * @var HttpClient
     */
    private $httpClient;

    /**
     * Token constructor.
     *
     * @param HttpClient $httpClient
     */
    public function __construct($httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @param $username
     * @param $password
     *
     * @throws \DpdConnect\Sdk\Exceptions\AuthenticateException
     * @throws \DpdConnect\Sdk\Exceptions\HttpException
     */
    public function getPublicJWTToken($username, $password)
    {
        $requestBody = [
            'username' => $username,
            'password' => $password,
            'scope' => 'public',
        ];

        list($status, $response) = $this->httpClient->sendRequest(
            HttpClient::REQUEST_POST,
            'auth/login',
            false,
            [
                'Content-Type'  => 'application/json'
            ],
            json_encode($requestBody)
        );

        if ($status !== 200) {
            return $response;
        }

        $decoded = json_decode($response, true);
        if ($decoded === null) {
            return $response;
        }

        return $decoded['token'];
    }
}
