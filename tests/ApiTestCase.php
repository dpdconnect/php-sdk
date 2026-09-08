<?php

namespace DpdConnect\Sdk\Test;

use donatj\MockWebServer\MockWebServer;
use donatj\MockWebServer\Response;
use donatj\MockWebServer\ResponseStack;
use DpdConnect\Sdk\Client;
use DpdConnect\Sdk\ClientBuilder;
use DpdConnect\Sdk\Resources\Authentication as AuthenticationResource;
use PHPUnit\Framework\TestCase;

abstract class ApiTestCase extends TestCase
{
    /** @var MockWebServer */
    protected $server;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        // Port 0 lets MockWebServer pick a free port; a fixed port makes the
        // suite fail whenever something else already listens on it.
        // The host must stay 127.0.0.1 — see assertion in createClient().
        $this->server = new MockWebServer(0, '127.0.0.1');
        $this->server->start();

        $this->server->setResponseOfPath(
            '/'.AuthenticationResource::RESOURCE_URI_AUTH,
            new ResponseStack(
                new Response($this->getAuthenticatedJson())
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        $this->server->stop();
    }

    /**
     * @return Client
     */
    protected function createClient()
    {
        $serverRoot = $this->server->getServerRoot();

        $clientBuilder = new ClientBuilder($serverRoot);

        // ClientBuilder silently falls back to Client::ENDPOINT (the live DPD API)
        // when the endpoint does not match its URL pattern — which is the case for
        // hostnames without a dot, such as "localhost". Fail loudly instead of
        // letting the test suite fire requests at production.
        $this->assertSame(
            $serverRoot,
            $clientBuilder->getEndpoint(),
            'ClientBuilder rejected the mock server endpoint and fell back to the live DPD API.'
        );

        return $clientBuilder->buildAuthenticatedByPassword(
            'username',
            'password'
        );
    }

    private function getAuthenticatedJson()
    {
        return <<<JSON
            {
                "token": "this-is-a-jwt-token"
            }
JSON;
    }
}
