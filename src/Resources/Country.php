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
class Country extends BaseResource
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

        $this->resourceClient->setResourceName('api/connect/v1/countries');
        $countries = $this->resourceClient->getResources($query);

        $this->storeCachedList($countries, $query);

        return $countries;
    }

    private function getCachedList($query)
    {
        $filename = sys_get_temp_dir() . '/dpd/' . sha1('dpd' . date('Ymd') . serialize($query));

        if (!file_exists($filename) || filesize($filename) == 0) {
            return false;
        }

        $handle = fopen($filename, "r");

        return unserialize(fread($handle, filesize($filename)));
    }

    private function storeCachedList($countries, $query)
    {
        if (!file_exists(sys_get_temp_dir() . '/dpd/')) {
            mkdir(sys_get_temp_dir() . '/dpd/');
        }

        $filename = sys_get_temp_dir() .'/dpd/' . sha1('dpd' . date('Ymd') . serialize($query));
        $handle = fopen($filename, "w");
        fwrite($handle, serialize($countries));
        fclose($handle);
    }
}
