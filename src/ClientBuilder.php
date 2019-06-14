<?php

namespace DpdConnect\Sdk;

use DpdConnect\Sdk\Common\AuthenticatedHttpClient;
use DpdConnect\Sdk\Common\HttpClient;
use DpdConnect\Sdk\Common\Authentication;
use DpdConnect\Sdk\Common\ResourceClient;
use DpdConnect\Sdk\Resources\Authentication as AuthenticationResource;

class ClientBuilder implements ClientBuilderInterface
{
    /**
     * @var string
     */
    protected $endpoint;

    /**
     * @var HttpClient
     */
    protected $httpClient;

    /**
     * @var array meta
     */
    private $meta;

    /**
     * @param string $endpoint
     */
    public function __construct($endpoint = null, $meta = [])
    {
        if (!is_null($endpoint) && $endpoint !== '') {
            $this->endpoint = $endpoint;
        } else {
            $this->endpoint = Client::ENDPOINT;
        }

        $this->meta = $meta;
    }

    /**
     * @return string|null
     */
    public function getEndpoint()
    {
        return $this->endpoint;
    }

    /**
     * @return HttpClient
     */
    private function getHttpClient()
    {
        if (null === $this->httpClient) {
            $this->httpClient = new HttpClient($this->endpoint);
        }

        return $this->httpClient;
    }

    /**
     * @param HttpClient $httpClient
     * @return ClientBuilder
     */
    public function setHttpClient(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
        return $this;
    }

    /**
     * Build the dpd connect client authenticated by user name and password
     *
     * @param string $username Username to use for the authentication
     * @param string $password Password associated to the username
     *
     * @return ClientInterface
     */
    public function buildAuthenticatedByPassword($username, $password)
    {
        $authentication = Authentication::fromPassword($username, $password);

        return $this->buildAuthenticatedClient($authentication);
    }

    /**
     * Build the dpd connect client authenticated by jwt token
     *
     * @param string $jwtToken     JWT tokken for authentication
     *
     * @return ClientInterface
     */
    public function buildAuthenticatedByJwtToken($jwtToken)
    {
        $authentication = Authentication::fromJwtToken($jwtToken);

        return $this->buildAuthenticatedClient($authentication);
    }

    /**
     * @param Authentication $authentication
     *
     * @return ClientInterface
     */
    protected function buildAuthenticatedClient(Authentication $authentication)
    {
        list($resourceClient) = $this->setUp($authentication);

        $client = new Client($authentication, null, $resourceClient, $this->endpoint);

        return $client;
    }

    /**
     * @param Authentication $authentication
     *
     * @return array
     */
    protected function setUp(Authentication $authentication)
    {
        $authenticationResource = new AuthenticationResource($this->getHttpClient());
        $authenticatedHttpClient = new AuthenticatedHttpClient(
            $this->getHttpClient(),
            $authenticationResource,
            $authentication
        );


        $resourceClient = new ResourceClient(
            $authenticatedHttpClient
        );

        return [$resourceClient];
    }
}
