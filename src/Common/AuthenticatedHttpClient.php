<?php

namespace DpdConnect\Sdk\Common;

use DpdConnect\Sdk\Exceptions\AuthenticateException;

class AuthenticatedHttpClient
{
    /**
     * @var HttpClient
     */
    protected $basicHttpClient;

    /**
     * @var AuthenticationResourceInterface
     */
    protected $authenticationResource;

    /**
     * @var Authentication
     */
    protected $authentication;

    /**
     * @param HttpClient $basicHttpClient
     * @param AuthenticationResourceInterface $authenticationResource
     * @param Authentication $authentication
     */
    public function __construct(
        HttpClient $basicHttpClient,
        AuthenticationResourceInterface $authenticationResource,
        Authentication $authentication
    ) {
        $this->basicHttpClient = $basicHttpClient;
        $this->authenticationResource = $authenticationResource;
        $this->authentication = $authentication;
    }

    /**
     * {@inheritdoc}
     */
    public function sendRequest($httpMethod, $resourceName, array $query = [], array $headers = [], $body = null)
    {
        if (null === $this->authentication->getJwtToken()) {
            $tokens = $this->authenticationResource->authenticateByPassword(
                $this->authentication->getUsername(),
                $this->authentication->getPassword()
            );

            $this->authentication
                ->setJwtToken($tokens['token']);
        }

        try {
            $headers[] =  sprintf('Authorization: Bearer %s', $this->authentication->getJwtToken());

            $response = $this->basicHttpClient->sendRequest($httpMethod, $resourceName, $query, $headers, $body);
        } catch (AuthenticateException $e) {
            $tokens = $this->authenticationResource->authenticateByRefreshToken(
                $this->authentication->getClientId(),
                $this->authentication->getSecret(),
                $this->authentication->getRefreshToken()
            );

            $this->authentication
                ->setAccessToken($tokens['access_token'])
                ->setRefreshToken($tokens['refresh_token']);

            $headers[] =  sprintf('Authorization: Bearer %s', $this->authentication->getAccessToken());
            $response =  $this->basicHttpClient->sendRequest($httpMethod, $resourceName, $query, $headers, $body)
                                               ->setAuthentication($this->authentication);
        }

        return $response;
    }
}
