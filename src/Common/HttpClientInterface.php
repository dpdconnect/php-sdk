<?php

namespace DpdConnect\Sdk\Common;

use DpdConnect\Sdk\Exceptions\AuthenticateException;
use DpdConnect\Sdk\Exceptions\HttpException;
use DpdConnect\Sdk\Objects\MetaData;

/**
 * Interface HttpClientInterface
 *
 * @package DpdConnect\Sdk\Common
 */
interface HttpClientInterface
{
    /**
     * @param MetaData $meta
     */
    public function setMeta($meta = null);

    /**
     * @param string $userAgent
     */
    public function addUserAgentString($userAgent);

    /**
     * @param Authentication $authentication
     */
    public function setAuthentication(Authentication $authentication);

    /**
     * @param string $resourceName
     * @param mixed  $query
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
     *
     * @return mixed|null
     */
    public function getHttpOption($option);

    /**
     * @param string      $method
     * @param string      $resourceName
     * @param mixed       $query
     * @param string|null $body
     *
     * @return array
     *
     * @throws AuthenticateException
     * @throws HttpException
     */
    public function sendRequest($method, $resourceName, $query = null, $headers = [], $body = null);
}
