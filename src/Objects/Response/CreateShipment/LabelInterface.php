<?php

namespace DpdConnect\Sdk\Objects\Response\CreateShipment;

interface LabelInterface
{
    /**
     * @return \DpdConnect\Sdk\Objects\Response\Generic\ItemStatusInterface
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
