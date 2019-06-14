<?php

namespace DpdConnect\Sdk\Common;

use DpdConnect\Sdk\Common;
use DpdConnect\Sdk\Exceptions;

interface HttpClientInterface
{
    /**
     * @param array $meta
     */
    public function setMeta(array $meta = []);

    /**
     * @param string $userAgent
     */
    public function addUserAgentString($userAgent);

    /**
     * @param Common\Authentication $Authentication
     */
    public function setAuthentication(Common\Authentication $Authentication);

    /**
     * @param string $resourceName
     * @param mixed $query
     *
     * @return string
     */
    public function getRequestUrl($resourceName, $query);

    /**
     * @param array $headers
     */
    public function setHeaders(array $headers);

    /**
     * @param $key
     * @param $value
     */
    public function addHttpOption($option, $value);

    /**
     * @param $option
     * @return mixed|null
     */
    public function getHttpOption($option);

    /**
     * @param string $method
     * @param string $resourceName
     * @param mixed $query
     * @param string|null $body
     *
     * @return array
     *
     * @throws Exceptions\AuthenticateException
     * @throws Exceptions\HttpException
     */
    public function sendRequest($method, $resourceName, $query = null, $headers = [], $body = null);
}
