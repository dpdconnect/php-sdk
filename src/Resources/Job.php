<?php

namespace DpdConnect\Sdk\Resources;

use DpdConnect\Sdk\Common\ResourceClient;
use InvalidArgumentException;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class Job extends BaseResource
{
    /**
     * @param $id
     *
     * @return array
     */
    public function getState($id)
    {
        if (is_null($id)) {
            throw new InvalidArgumentException('No job id provided.');
        }

        $this->resourceClient->setResourceName('api/connect/v1/job/'.$id);

        return $this->resourceClient->getResource();
    }
}
