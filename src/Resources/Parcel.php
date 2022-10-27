<?php

namespace DpdConnect\Sdk\Resources;

use DpdConnect\Sdk\Common\ResourceClient;
use DpdConnect\Sdk\Exceptions\DpdException;
use InvalidArgumentException;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class Parcel extends BaseResource
{
    /**
     * @param array $query
     *
     * @return array
     * @throws DpdException
     */
    public function getStatus($id)
    {
        if (is_null($id)) {
            throw new InvalidArgumentException('No parcel id provided.');
        }

        $this->resourceClient->setResourceName('api/connect/v1/parcel/status/'.$id);

        return $this->resourceClient->getResource();
    }

    /**
     * @param $id
     *
     * @return array|mixed
     */
    public function getLabel($id)
    {
        if (is_null($id)) {
            throw new InvalidArgumentException('No parcel id provided.');
        }

        $this->resourceClient->setResourceName('api/connect/v1/parcel/label/'.$id);

        return $this->resourceClient->getResource();
    }
}
