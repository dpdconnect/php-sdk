<?php

namespace DpdConnect\Sdk\Resources;

use DpdConnect\Sdk\Common;
use DpdConnect\Sdk\Common\ResourceClient;
use DpdConnect\Sdk\Exceptions\DpdException;
use DpdConnect\Sdk\Objects;
use InvalidArgumentException;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class Job extends BaseResource
{
    /**
     * @param ResourceClient $resourceClient
     */
    public function __construct(
        ResourceClient $resourceClient
    ) {
        parent::__construct($resourceClient);
    }

    /**
     * @param array $query
     * @return array
     * @throws DpdException
     */
    public function getState($id)
    {
        if (is_null($id)) {
            throw new \InvalidArgumentException('No job id provided.');
        }

        $this->resourceClient->setResourceName('api/connect/v1/job/' . $id);

        return $this->resourceClient->getResource();
    }
}
