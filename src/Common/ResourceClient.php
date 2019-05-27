<?php

namespace DpdConnect\Sdk\Common;

use DpdConnect\Sdk\Exceptions\AuthenticateException;
use DpdConnect\Sdk\Exceptions\RequestException;
use DpdConnect\Sdk\Exceptions\ServerException;
use DpdConnect\Sdk\Objects\ObjectFactory;
use DpdConnect\Sdk\Objects\ResourceResponse;

class ResourceClient implements ResourceClientInterface
{
    /**
     * @var AuthenticatedHttpClient
     */
    protected $httpClient;

    /**
     * @var string The resource name as it is known at the server
     */
    protected $resourceName;

    /**
     * @var object
     */
    protected $object;

    /**
     * @param AuthenticatedHttpClient $httpClient
     */
    public function __construct(
        AuthenticatedHttpClient $httpClient
    ) {
        $this->httpClient = $httpClient;
    }

    /**
     * @return string
     */
    public function getResourceName()
    {
        return $this->resourceName;
    }

    /**
     * @param string $resourceName
     * @return ResourceClient
     */
    public function setResourceName($resourceName)
    {
        $this->resourceName = $resourceName;
        return $this;
    }

    /**
     * @return object
     */
    public function getObject()
    {
        return $this->object;
    }

    /**
     * @param object $object
     * @return ResourceClient
     */
    public function setObject($object)
    {
        $this->object = $object;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getResource($query = [])
    {
        list($status, $response) = $this->httpClient->sendRequest(
            'GET',
            $this->getResourceName(),
            $query,
            ['Accept' => '*/*']
        );

        if ($status !== 200) {
            return $response;
        }

        return json_decode($response, true);
    }

    /**
     * {@inheritdoc}
     */
    public function getResources($query = [])
    {
        $limit = 20;
        $withCount = false;

        if (null !== $limit) {
            $query['limit'] = $limit;
        }

        if (null !== $withCount) {
            $query['with_count'] = $withCount;
        }

        return $this->getResource($query);
    }

    /**
     * {@inheritdoc}
     */
    public function createResource($query = [], $body = [])
    {
//        print_r($body);
//        die;
        list($status, $response) = $this->httpClient->sendRequest(
            'POST',
            $this->getResourceName(),
            $query,
            ['Content-Type: application/json'],
            json_encode($body, JSON_PRESERVE_ZERO_FRACTION)
        );

        return $this->parseResponse($status, $response);
    }

    /**
     * @param array $query
     * @return array|int
     */
    public function deleteResource(array $query = [])
    {
        $response = $this->httpClient->sendRequest('DELETE', $this->getResourceName(), $query);

        return $response;
    }

    /**
     * @param $items
     * @return array
     */
    private function parseValidationErrors($items)
    {
        $errors = [];

        if (count($items) > 0) {
            $items = array_shift($items);
            array_walk($items, function ($item) use (&$errors) {
                $field = function ($item) {
                    if (key_exists('dataPath', $item)) {
                        return str_replace('body.', '', $item['dataPath']);
                    }

                    var_dump($item);
                };

                $errors[$field($item)] = $item;
            });
        }

        return $errors;
    }

    /**
     * @param $status
     * @param $response
     * @param array $headers
     * @return $this
     *
     * @throws RequestException
     * @throws ServerException
     * @throws AuthenticateException
     */
    public function parseResponse($status, $response, $headers = [])
    {
        $errors = [];
        $validation = [];
        $response = @json_decode($response, true);

        if ($response === null or $response === false) {
            throw new ServerException('Got an invalid JSON response from the server.');
        }

        if (!empty($response['_embedded'])) {
            $validation = $this->parseValidationErrors($response['_embedded']);
        }

        if (!empty($response['errors']) || count($errors) !== 0 || count($validation) !== 0) {
            $responseError = new ResponseError($response, $validation);
            throw new RequestException($responseError);
        }

        return ObjectFactory::create(ResourceResponse::class, [
            'status'     => $status,
            'errors'     => $errors,
            'validation' => $validation,
            'headers'    => $headers,
            'content'    => $response
        ]);
    }
}
