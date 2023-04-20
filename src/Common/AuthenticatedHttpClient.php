<?php

namespace DpdConnect\Sdk\Common;

use DpdConnect\Sdk\Exceptions\AuthenticateException;

/**
 * Class AuthenticatedHttpClient
 *
 * @package DpdConnect\Sdk\Common
 */
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

            if (isset($tokens['token'])) {
                $this->authentication
                    ->setJwtToken($tokens['token']);
                if (is_callable($this->authentication->tokenUpdateCallback)) {
                    call_user_func($this->authentication->tokenUpdateCallback, $this->authentication->getJwtToken());
                }
            }
        }

        try {
            $headers[] = sprintf('Authorization: Bearer %s', $this->authentication->getJwtToken());

            $response = $this->basicHttpClient->sendRequest($httpMethod, $resourceName, $query, $headers, $body);
        } catch (AuthenticateException $e) {

            try {
                $token = $this->authenticationResource->authenticateByPassword(
                    $this->authentication->getUsername(),
                    $this->authentication->getPassword()
                );

                $this->authentication
                    ->setJwtToken($token['token']);
                if (is_callable($this->authentication->tokenUpdateCallback)) {
                    call_user_func($this->authentication->tokenUpdateCallback, $this->authentication->getJwtToken());
                }

                // Since the Authorization Bearer always is the last added item, we overwrite it like this
                unset($headers[0]);
                $headers[count($headers) - 1] = sprintf(
                    'Authorization: Bearer %s',
                    $this->authentication->getJwtToken()
                );
                $response = $this->basicHttpClient->sendRequest($httpMethod, $resourceName, $query, $headers, $body);
            } catch (AuthenticateException $exception) {
                throw new DpdException('Error response from DPD. '.$exception->getMessage(), $exception->getCode(), $exception);
            }

        }

        return $response;
    }
}
