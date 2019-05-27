<?php

namespace DpdConnect\Sdk\Resources;

use DpdConnect\Sdk\Common\ResourceClient;
use DpdConnect\Sdk\Common\ResponseError;
use DpdConnect\Sdk\Exceptions;
use DpdConnect\Sdk\Exceptions\RequestException;
use DpdConnect\Sdk\Exceptions\ServerException;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 * @SuppressWarnings(PHPMD.NumberOfChildren)
 * @SuppressWarnings(PHPMD.TooManyFields)
 */
class BaseResource
{
    /**
     * @var ResourceClient
     */
    protected $resourceClient;

    /**
     * @var object
     */
    protected $object;

    /**
     * @param ResourceClient $resourceClient
     */
    public function __construct(ResourceClient $resourceClient)
    {
        $this->resourceClient = $resourceClient;
    }

    /**
     * @param $object
     */
    public function setObject($object)
    {
        $this->object = $object;
    }

    /**
     * @return object
     */
    public function getObject()
    {
        return $this->object;
    }

    /**
     * @param string $body
     * @return $this
     *
     * @throws Exceptions\AuthenticateException
     * @throws RequestException
     * @throws ServerException
     */
    public function processRequest($body)
    {
        $body = @json_decode($body);

        if ($body === null or $body === false) {
            throw new ServerException('Got an invalid JSON response from the server.');
        }

        if (empty($body->errors)) {
            return $this->object->loadFromArray($body);
        }

        $ResponseError = new ResponseError($body);
        throw new RequestException($ResponseError->getErrorString());
    }
}
