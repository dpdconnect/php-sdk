<?php

namespace DpdConnect\Sdk\Test\Unit;

use donatj\MockWebServer\Response;
use DpdConnect\Sdk\Common\HttpClient;
use DpdConnect\Sdk\Resources\Authentication as AuthenticationResource;
use DpdConnect\Sdk\Test\ApiTestCase;

/**
 * Exercises HttpClient::sendRequest() against a real HTTP server.
 *
 * This is the only test that runs the cURL code path. Without it the PHP version
 * matrix in CI cannot catch runtime regressions such as a function that becomes
 * deprecated in a newer PHP release — see docs/ci-php-version-matrix.md.
 */
class HttpClientRequestTest extends ApiTestCase
{
    public function testGetRequestReturnsStatusAndBody()
    {
        $this->server->setResponseOfPath('/ping', new Response('{"pong":true}'));

        $client = new HttpClient($this->server->getServerRoot());
        list($status, $body) = $client->sendRequest(HttpClient::REQUEST_GET, 'ping');

        $this->assertSame(200, $status);
        $this->assertJsonStringEqualsJsonString('{"pong":true}', $body);
    }

    public function testPostRequestSendsBodyAndReturnsResponse()
    {
        $this->server->setResponseOfPath('/echo', new Response('{"received":true}'));

        $client = new HttpClient($this->server->getServerRoot());
        list($status, $body) = $client->sendRequest(
            HttpClient::REQUEST_POST,
            'echo',
            false,
            ['X-Test: post'],
            json_encode(['hello' => 'world'])
        );

        $this->assertSame(200, $status);
        $this->assertJsonStringEqualsJsonString('{"received":true}', $body);

        $lastRequest = $this->server->getLastRequest();
        $this->assertNotNull($lastRequest);
        $this->assertSame(HttpClient::REQUEST_POST, $lastRequest->getRequestMethod());
        $this->assertJsonStringEqualsJsonString('{"hello":"world"}', $lastRequest->getInput());
    }

    public function testAuthenticationResourceCompletesRoundTrip()
    {
        // The auth/login response is registered by ApiTestCase::setUp().
        $client = new HttpClient($this->server->getServerRoot());
        $authentication = new AuthenticationResource($client);

        $result = $authentication->authenticateByPassword('username', 'password');

        $this->assertSame(['token' => 'this-is-a-jwt-token'], $result);
    }
}
