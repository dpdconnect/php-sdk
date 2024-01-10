<?php

namespace DpdConnect\Sdk;

use DpdConnect\Sdk\Common\AuthenticatedHttpClient;
use DpdConnect\Sdk\Common\Authentication;
use DpdConnect\Sdk\Common\HttpClient;
use DpdConnect\Sdk\Common\ResourceClient;
use DpdConnect\Sdk\Resources\Authentication as AuthenticationResource;

/**
 * Class ClientBuilder
 *
 * @package DpdConnect\Sdk
 */
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
     * @var array
     */
    private $meta;

    /**
     * @param string $endpoint
     * @param null   $meta
     */
    public function __construct($endpoint = null, $meta = null)
    {
        $this->endpoint = 1 === preg_match('#((https?)://(\S*?\.\S*?))([\s)\[\]{},;"\':<]|\.\s|$)#i', $endpoint ?: '') ? $endpoint : Client::ENDPOINT;
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
            $this->httpClient->setMeta($this->meta);
        }

        return $this->httpClient;
    }

    /**
     * @param HttpClient $httpClient
     *
     * @return ClientBuilder
     */
    public function setHttpClient(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
        $this->httpClient->setMeta($this->meta);

        return $this;
    }

    /**
     * Build the dpd connect client authenticated by user name and password
     *
     * @param string $username Username to use for the authentication
     * @param string $password Password associated to the username
     *
     * @return Client
     */
    public function buildAuthenticatedByPassword($username, $password)
    {
        $authentication = Authentication::fromPassword($username, $password);

        return $this->buildAuthenticatedClient($authentication);
    }

    /**
     * Build the dpd connect client authenticated by jwt token
     *
     * @param string $jwtToken JWT tokken for authentication
     *
     * @return Client
     */
    public function buildAuthenticatedByJwtToken($jwtToken)
    {
        $authentication = Authentication::fromJwtToken($jwtToken);

        return $this->buildAuthenticatedClient($authentication);
    }

    /**
     * @param Authentication $authentication
     *
     * @return Client
     */
    protected function buildAuthenticatedClient(Authentication $authentication)
    {
        list($resourceClient) = $this->setUp($authentication);

        return new Client($authentication, $this->getHttpClient(), $resourceClient, $this->endpoint);
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
