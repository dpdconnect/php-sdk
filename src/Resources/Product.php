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
    public function getList($query = [])
    {
        $result = $this->getCachedList($query);
        if ($result) {
            return $result;
        }

        $this->resourceClient->setResourceName('api/connect/v1/available-products');
        try {
            $products = $this->resourceClient->getResources($query);
            $this->storeCachedList($products, $query);
            return $products;
        } catch (DpdException $e) {
            throw $e;
        }
    }

    /**
     * @param $query
     *
     * @return false|mixed
     */
    private function getCachedList($query)
    {
        $filename = sys_get_temp_dir() . '/dpd/' . sha1('dpd-products' . date('YmdH') . serialize($query));

        if (!file_exists($filename) || filesize($filename) == 0) {
            return false;
        }

        return unserialize(file_get_contents($filename));
    }

    /**
     * @param $products
     * @param $query
     */
    private function storeCachedList($products, $query)
    {
        if (!file_exists(sys_get_temp_dir() . '/dpd/')) {
            mkdir(sys_get_temp_dir() . '/dpd/');
        }

        $filename = sys_get_temp_dir() .'/dpd/' . sha1('dpd-products' . date('YmdH') . serialize($query));
        file_put_contents($filename, serialize($products));
    }
}
