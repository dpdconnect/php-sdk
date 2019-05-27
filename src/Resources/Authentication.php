<?php

namespace DpdConnect\Sdk\Resources;

use DpdConnect\Sdk\Common\AuthenticationResourceInterface;
use DpdConnect\Sdk\Common\HttpClient;
use DpdConnect\Sdk\Common\ResponseError;
use DpdConnect\Sdk\Exceptions\RequestException;
use DpdConnect\Sdk\Exceptions\ServerException;

class Authentication implements AuthenticationResourceInterface
{
    const RESOURCE_URI_AUTH = 'auth/login';

    /**
     * @param HttpClient $HttpClient
     */
    public function __construct(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * {@inheritdoc}
     */
    public function authenticateByPassword($username, $password)
    {
        $requestBody = [
            'username'   => $username,
            'password'   => $password,
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
     * @throws \DpdConnect\Sdk\Exceptions\AuthenticateException
     * @throws \DpdConnect\Sdk\Exceptions\HttpException
     */
    protected function authenticate($requestBody)
    {
        $headers = [
            'Content-Type'  => 'application/json'
        ];

        $response = $this->httpClient->sendRequest(
            HttpClient::REQUEST_POST,
            self::RESOURCE_URI_AUTH,
            false,
            $headers,
            json_encode($requestBody)
        );

        return $this->processRequest($response);
    }

    /**
     * @param $response
     * @return array
     *
     * @throws RequestException
     * @throws ServerException
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
