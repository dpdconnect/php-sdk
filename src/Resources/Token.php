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
        $result = $this->getCachedPublicJWTToken($username);
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

        $this->storeCachedPublicJWTToken($decoded['token'], $username);

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
     * @param $username
     *
     * @return false|mixed
     */
    private function getCachedPublicJWTToken($username)
    {
        $filename = sys_get_temp_dir() . '/dpd/' . sha1('dpd-token' . date('YmdH') . serialize($username));

        if (!file_exists($filename) || filesize($filename) == 0) {
            return false;
        }

        return unserialize(file_get_contents($filename));
    }

    /**
     * @param $token
     * @param $username
     */
    private function storeCachedPublicJWTToken($token, $username)
    {
        if (!file_exists(sys_get_temp_dir() . '/dpd/')) {
            mkdir(sys_get_temp_dir() . '/dpd/');
        }

        $filename = sys_get_temp_dir() .'/dpd/' . sha1('dpd-token' . date('YmdH') . serialize($username));
        file_put_contents($filename, serialize($token));
    }
}
