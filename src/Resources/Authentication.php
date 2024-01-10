<?php

namespace DpdConnect\Sdk\Resources;

use DpdConnect\Sdk\Common\AuthenticationResourceInterface;
use DpdConnect\Sdk\Common\HttpClient;
use DpdConnect\Sdk\Common\ResponseError;
use DpdConnect\Sdk\Exceptions\AuthenticateException;
use DpdConnect\Sdk\Exceptions\RequestException;
use DpdConnect\Sdk\Exceptions\ServerException;

/**
 * Class Authentication
 *
 * @package DpdConnect\Sdk\Resources
 */
class Authentication implements AuthenticationResourceInterface
{
    const RESOURCE_URI_AUTH = 'auth/login';

    private $httpClient;

    public function __construct($httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * {@inheritdoc}
     */
    public function authenticateByPassword($username, $password)
    {
        $requestBody = [
            'username' => $username,
            'password' => $password,
            'scope' => 'private',
        ];

        return $this->authenticate($requestBody);
    }

    /**
     * Authenticates the client by requesting the access token and the refresh token.
     *
     * @param array $requestBody body of the request to authenticate
     *
     * @return array returns the body of the response containing access token and refresh token
     * @throws RequestException
     * @throws ServerException
     */
    protected function authenticate($requestBody)
    {
        $headers = [
            'Content-Type' => 'application/json',
        ];
        try {
            $response = $this->httpClient->sendRequest(
                HttpClient::REQUEST_POST,
                self::RESOURCE_URI_AUTH,
                false,
                $headers,
                json_encode($requestBody)
            );
            return $this->processRequest($response);
        } catch (\Exception $exception) {
            return [];
        }
    }

    /**
     * @param $response
     *
     * @return array
     *
     * @throws RequestException
     * @throws ServerException|AuthenticateException
     */
    public function processRequest($response)
    {
        list($status, $body) = $response;

        $body = @json_decode($body, true);

        if ($body === null or $body === false) {
            throw new ServerException('Got an invalid JSON response from the server.');
        }

        if ($status === 200 && empty($body['errors'])) {
            return $body;
        }

        $responseError = new ResponseError($body);
        throw new RequestException($responseError);
    }
}
