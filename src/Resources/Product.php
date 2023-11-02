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
class Product extends BaseResource
{
    /**
     * @param array $query
     * @return array
     * @throws DpdException
     */
    public function getList($query = [])
    {
        $result = $this->cacheWrapper->getCachedList($query);
        if ($result) {
            return $result;
        }

        $this->resourceClient->setResourceName('api/connect/v1/available-products');
        try {
            $products = $this->resourceClient->getResources($query);

            if (is_array($products)) {
                $this->cacheWrapper->storeCachedList($products, $query);
                return $products;
            } else {
                return [];
            }
        } catch (DpdException $e) {
            $result = $this->cacheWrapper->getCachedList($query, true); //a year

            // So we had a failure save cache now for an hour
            $this->cacheWrapper->storeCachedList($result, $query);

            if ($result && is_array($result)) {
                return $result;
            }
            return [];
        }
    }
}
