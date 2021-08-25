<?php

namespace DpdConnect\Sdk\Api\Data\Response;

/**
 * Interface ItemStatusInterface
 *
 * @package DpdConnect\Sdk\Api\Data\Response
 */
interface ItemStatusInterface extends ResponseStatusInterface
{
    /**
     * @return string
     */
    public function getIdentifier();
}
