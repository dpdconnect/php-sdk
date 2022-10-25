<?php

namespace DpdConnect\Sdk\Resources;

use DpdConnect\Sdk\CacheWrapper;
use DpdConnect\Sdk\Common\HttpClient;

/**
 * Class Token
 *
 * @package DpdConnect\Sdk\Resources
 */
class Token implements CacheableInterface
{
    /**
     * @var HttpClient
     */
    private $httpClient;

    /**
     * @var CacheWrapper|null
     */
    private $cacheWrapper = null;

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
        $result = $this->cacheWrapper->getCachedList($username, false, 'dpd_token');
        if ($result && $this->isTokenValid($result)) {
            return $result;
        }

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

        $this->cacheWrapper->storeCachedList($decoded['token'], $username, 'dpd_token');

        return $decoded['token'];
    }

    /**
     * @param $token
     *
     * @return bool
     */
    private function isTokenValid($token)
    {
        $explodedToken = explode('.', $token);

        // Check if token has header, payload and signature
        if (count($explodedToken) != 3) {
            return false;
        }

        list($header, $payload, $signature) = $explodedToken;

        $payload = json_decode(base64_decode($payload), true);

        // Check if token is expired
        // Subtract 5 minutes of token to prevent returning a shortly-expiring token
        if (time() >= (int)$payload['exp'] - (5*60)) {
            return false;
        }

        return true;
    }

    /**
     * @param CacheWrapper|null $cacheWrapper
     */
    public function setCacheWrapper($cacheWrapper)
    {
        $this->cacheWrapper = $cacheWrapper;
    }
}
