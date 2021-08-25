<?php

namespace DpdConnect\Sdk\Objects\Response;

use DpdConnect\Sdk\Objects\Response\CreateShipment\LabelInterface;
use DpdConnect\Sdk\Objects\Response\Generic\ResponseStatusInterface;

/**
 * Interface ShipmentResponseInterface
 *
 * @package DpdConnect\Sdk\Objects\Response
 */
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
