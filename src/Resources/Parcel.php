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
class Parcel extends BaseResource
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
    public function getStatus($id)
    {
        if (is_null($id)) {
            throw new \InvalidArgumentException('No parcel id provided.');
        }

        $this->resourceClient->setResourceName('api/connect/v1/parcel/status/' . $id);

        return $this->resourceClient->getResource();
    }

    public function getLabel($id)
    {
        if (is_null($id)) {
            throw new \InvalidArgumentException('No parcel id provided.');
        }

        $this->resourceClient->setResourceName('api/connect/v1/parcel/label/' . $id);

        return $this->resourceClient->getResource();
    }
}
