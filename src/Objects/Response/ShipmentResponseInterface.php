<?php

namespace DpdConnect\Sdk\Objects\Response;

use DpdConnect\Sdk\Objects\Response\Generic\ResponseStatusInterface;

interface ShipmentResponseInterface
{
    /**
     * @return ResponseStatusInterface
     */
    public function getStatus();

    /**
     * @return LabelInterface[]
     */
    public function getItems();

    /**
     * @param string $sequenceNumber
     *
     * @return LabelInterface
     */
    public function getItem($sequenceNumber);
}
