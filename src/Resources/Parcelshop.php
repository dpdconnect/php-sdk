<?php

namespace DpdConnect\Sdk\Resources;

use DpdConnect\Sdk\Common\ResourceClient;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class Parcelshop extends BaseResource
{
    /**
     * @param $id
     *
     * @return Parcelshop
     */
    public function get($id)
    {
        if (is_null($id)) {
            throw new \InvalidArgumentException('No parcelshop id provided.');
        }

        $this->resourceClient->setResourceName('api/connect/v1/parcelshop/'.$id);

        return $this->resourceClient->getResource();
    }

    /**
     * @param array $query
     *
     * @return \DpdConnect\Sdk\Objects\Parcelshop[]
     */
    public function getList($query = [])
    {
        $this->resourceClient->setResourceName('api/connect/v1/parcelshop');
        $result = $this->resourceClient->getResources($query);
        if (!$result) {
            return [];
        }
        return $result;
    }
}
