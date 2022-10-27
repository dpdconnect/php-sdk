<?php

namespace DpdConnect\Sdk\Resources;

use DpdConnect\Sdk\Common\ResourceClient;

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
     *
     * @return array
     */
    public function getList($query = [])
    {
/*        $result = $this->getCachedList($query);

        if ($result) {
            return $result;
        }*/

        $this->resourceClient->setResourceName('location/country');
        $countries = $this->resourceClient->getResources($query);
        $this->storeCachedList($countries, $query);

        return $countries;
    }

    /**
     * @param $query
     *
     * @return false|mixed
     */
    private function getCachedList($query)
    {
        $filename = sys_get_temp_dir().'/dpd/'.sha1('dpd'.date('Ymd').serialize($query));

        if (!file_exists($filename) || filesize($filename) == 0) {
            return false;
        }

        return unserialize(file_get_contents($filename));
    }

    /**
     * @param $countries
     * @param $query
     */
    private function storeCachedList($countries, $query)
    {
        if (!file_exists(sys_get_temp_dir().'/dpd/')) {
            mkdir(sys_get_temp_dir().'/dpd/');
        }

        $filename = sys_get_temp_dir().'/dpd/'.sha1('dpd'.date('Ymd').serialize($query));
        file_put_contents($filename, serialize($countries));
    }
}
