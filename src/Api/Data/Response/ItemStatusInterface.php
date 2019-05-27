<?php

namespace DpdConnect\Sdk\Api\Data\Response;

interface ItemStatusInterface extends ResponseStatusInterface
{
    /**
     * @return string
     */
    public function getIdentifier();
}
