<?php

namespace DpdConnect\Sdk\Resources;

use DpdConnect\Sdk\Common\ResourceClient;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class Country extends BaseResource
{
    /**
     * @param array $query
     *
     * @return array
     */
    public function getList($query = [])
    {
        $result = $this->cacheWrapper->getCachedList($query);

        if ($result) {
            return $result;
        }

        $this->resourceClient->setResourceName('api/connect/v1/countries');
        $countries = $this->resourceClient->getResources($query);
        $this->cacheWrapper->storeCachedList($countries, $query);

        return $countries;
    }
}
