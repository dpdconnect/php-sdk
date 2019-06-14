<?php

namespace DpdConnect\Sdk\Common;

use DpdConnect\Sdk\Client;
use DpdConnect\Sdk\Common;
use DpdConnect\Sdk\Exceptions;
use DpdConnect\Sdk\Exceptions\HttpException;
use InvalidArgumentException;

class HttpClient implements HttpClientInterface
{
    const REQUEST_GET = 'GET';
    const REQUEST_POST = 'POST';
    const REQUEST_DELETE = 'DELETE';
    const REQUEST_PUT = 'PUT';
    const REQUEST_PATCH = "PATCH";

    const HTTP_NO_CONTENT = 204;

    /**
     * @var string
     */
    protected $endpoint;

    /**
     * @var array
     */
    protected $userAgent = [];

    /**
     * @var Common\Authentication
     */
    protected $authentication;

    /**
     * @var int
     */
    private $timeout = 10;

    /**
     * @var int
     */
    private $connectionTimeout = 10;

    /**
     * @var array
     */
    private $headers = [];

    /**
     * @var array
     */
    private $httpOptions = [];

    /**
     * @var array
     */
    private $meta;

    /**
     * @param string $endpoint
     * @param int    $timeout           > 0
     * @param int    $connectionTimeout >= 0
     * @param array  $headers
     */
    public function __construct($endpoint, $timeout = 10, $connectionTimeout = 10, $headers = [])
    {
        $this->endpoint = $endpoint;

        if (!is_int($timeout) || $timeout < 1) {
            throw new InvalidArgumentException(
                'Timeout must be an int > 0, got "' . is_object($timeout)
            );
        }

        $this->timeout = $timeout;

        if (!is_int($connectionTimeout) || $connectionTimeout < 0) {
            throw new InvalidArgumentException(
                sprintf(
                    is_object($connectionTimeout) ? get_class($connectionTimeout) :
                        gettype($connectionTimeout) . ' ' . var_export($connectionTimeout, true),
                    'Connection timeout must be an int >= 0, got "%s".'
                )
            );
        }

        $this->connectionTimeout = $connectionTimeout;
        $this->headers = $headers;
    }

    /**
     * @param array $meta
     */
    public function setMeta(array $meta = [])
    {
        $this->meta = $meta;
    }

    /**
     * @param string $userAgent
     */
    public function addUserAgentString($userAgent)
    {
        $this->userAgent[] = $userAgent;
    }

    /**
     * @param Common\Authentication $Authentication
     */
    public function setAuthentication(Common\Authentication $authentication)
    {
        $this->authentication = $authentication;
    }

    /**
     * @param string $resourceName
     * @param mixed  $query
     *
     * @return string
     */
    public function getRequestUrl($resourceName, $query)
    {
        $requestUrl = $this->endpoint . '/' . $resourceName;
        if ($query) {
            if (is_array($query)) {
                $query = http_build_query($query);
            }
            $requestUrl .= '?' . $query;
        }

        return $requestUrl;
    }

    /**
     * @param array $headers
     */
    public function setHeaders(array $headers)
    {
        $this->headers = $headers;
    }

    /**
     * @param $key
     * @param $value
     */
    public function addHttpOption($option, $value)
    {
        $this->httpOptions[$option] = $value;
    }

    /**
     * @param $option
     * @return mixed|null
     */
    public function getHttpOption($option)
    {
        return isset($this->httpOptions[$option]) ? $this->httpOptions[$option] : null;
    }

    /**
     * @param string $method
     * @param string $resourceName
     * @param mixed $query
     * @param array $headers
     * @param string|null $body
     * @return array
     *
     * @throws Exceptions\AuthenticateException
     * @throws Exceptions\HttpException
     */
    public function sendRequest($method, $resourceName, $query = null, $headers = [], $body = null)
    {
        $curl = curl_init();

//        if ($this->authentication === null) {
//            throw new Exceptions\AuthenticateException('Can not perform API Request without Authentication');
//        }

        list($webshopType, $webshopVersion, $pluginVersion) = $this->parseMeta();

        $baseHeaders = [
            'User-agent: ' . implode(' ', $this->userAgent),
            'Accept: application/json',
            'Content-Type: application/json',
            'Accept-Charset: utf-8',
            'x-php-version: ' . $this->getPhpVersion(),
            'x-webshop-type: ' . $webshopType,
            'x-webshop-version: ' . $webshopVersion,
            'x-plugin-version: ' . $pluginVersion,
            'x-sdk-version: ' . Client::CLIENT_VERSION,
            'x-os: ' . php_uname(),
        ];

        $baseHeaders = array_merge($baseHeaders, $headers, $this->headers);

        curl_setopt($curl, CURLOPT_HTTPHEADER, $baseHeaders);
        curl_setopt($curl, CURLOPT_HEADER, true);
        curl_setopt($curl, CURLOPT_URL, $this->getRequestUrl($resourceName, $query));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, $this->timeout);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $this->connectionTimeout);

        foreach ($this->httpOptions as $option => $value) {
            curl_setopt($curl, $option, $value);
        }

        if ($method === self::REQUEST_GET) {
            curl_setopt($curl, CURLOPT_HTTPGET, true);
        } elseif ($method === self::REQUEST_POST) {
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
        } elseif ($method === self::REQUEST_DELETE) {
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, self::REQUEST_DELETE);
        } elseif ($method === self::REQUEST_PUT) {
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, self::REQUEST_PUT);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
        } elseif ($method === self::REQUEST_PATCH) {
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, self::REQUEST_PATCH);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
        }

        $response = curl_exec($curl);

        if ($response === false) {
            throw new HttpException(curl_error($curl), curl_errno($curl));
        }

        $responseStatus = (int) curl_getinfo($curl, CURLINFO_HTTP_CODE);

        // Split the header and body
        $parts = explode("\r\n\r\n", $response, 3);
        if (in_array($parts[0], ['HTTP/1.1 200 OK', 'HTTP/1.1 100 Continue'])) {
            list($responseHeader, $responseBody) = [$parts[1], $parts[2]];
        } else {
            list($responseHeader, $responseBody) = [$parts[0], $parts[1]];
        }

        curl_close($curl);

        return [$responseStatus, $responseBody];
    }

    /**
     * @return string
     */
    private function getPhpVersion()
    {
        if (!defined('PHP_VERSION_ID')) {
            $version = explode('.', PHP_VERSION);
            define('PHP_VERSION_ID', $version[0] * 10000 + $version[1] * 100 + $version[2]);
        }

        return 'PHP/' . PHP_VERSION_ID;
    }

    private function parseMeta()
    {
        if (!$this->meta) {
            $this->meta = [];
        }

        $meta = $this->meta;

        $webshopType = isset($meta['webshopType']) ? $meta['webshopType'] : 'unknown';
        $webshopVersion = isset($meta['webshopVersion']) ? $meta['webshopVersion'] : 'unknown';
        $pluginVersion = isset($meta['pluginVersion']) ? $meta['pluginVersion'] : 'unknown';

        return [$webshopType, $webshopVersion, $pluginVersion];
    }
}
