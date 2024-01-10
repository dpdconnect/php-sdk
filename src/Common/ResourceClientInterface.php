<?php

namespace DpdConnect\Sdk\Common;

/**
 * Interface ResourceClientInterface
 *
 * @package DpdConnect\Sdk\Common
 */
interface ResourceClientInterface
{
    /**
     * Gets a resource.
     *
     * @param array $query
     *
     * @return array
     */
    public function getResource($query = []);

    /**
     * Gets a list of resources.
     *
     * @param array $query
     *
     * @return array
     */
    public function getResources($query = []);

    /**
     * Creates a resource.
     *
     * @param array $query
     * @param array $body Body of the request
     *
     * @return int Status code 201 indicating that the resource has been well created.
     */
    public function createResource($query = [], $body = []);

    /**
     * Deletes a resource.
     *
     * @param array $query URI parameters of the resource
     *
     * @return int Status code 204 indicating that the resource has been well deleted
     */
    public function deleteResource(array $query = []);
}
