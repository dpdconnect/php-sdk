<?php

namespace DpdConnect\Sdk\Api;

use DpdConnect\Sdk\Objects\Response\Generic\ItemStatusInterface;

/**
 * Interface ShipmentLabelInterface
 *
 * @package DpdConnect\Sdk\Api
 */
interface ShipmentLabelInterface
{
    /**
     * @return ItemStatusInterface
     */
    public function getStatus();

    /**
     * @return string
     */
    public function getSequenceNumber();

    /**
     * @return string
     */
    public function getTrackingNumber();

    /**
     * @return string
     */
    public function getLabel();

    /**
     * @return string
     */
    public function getReturnLabel();

    /**
     * @return string
     */
    public function getExportLabel();

    /**
     * @return string
     */
    public function getCodLabel();

    /**
     * @return string[]
     */
    public function getAllLabels();
}
