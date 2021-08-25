<?php

namespace DpdConnect\Sdk\Objects\Response\CreateShipment;

use DpdConnect\Sdk\Objects\Response\Generic\ItemStatusInterface;

/**
 * Interface LabelInterface
 *
 * @package DpdConnect\Sdk\Objects\Response\CreateShipment
 */
interface LabelInterface
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
