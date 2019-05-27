<?php

namespace DpdConnect\Sdk\Resources;

use DpdConnect\Sdk\Common;
use DpdConnect\Sdk\Common\ResourceClient;
use DpdConnect\Sdk\Objects;
use InvalidArgumentException;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class Parcelshop extends BaseResource
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
     * @param $id
     * @return Parcelshop
     */
    public function get($id)
    {
        if (is_null($id)) {
            throw new \InvalidArgumentException('No parcelshop id provided.');
        }

        $this->resourceClient->setResourceName('api/connect/v1/parcelshop/' . $id);

        return $this->resourceClient->getResource();
    }

    /**
     * @param array $query
     * @return Parcelshop
     */
    public function getList($query = [])
    {
        $this->resourceClient->setResourceName('api/connect/v1/parcelshop');
        return $this->resourceClient->getResources($query);
    }
}
