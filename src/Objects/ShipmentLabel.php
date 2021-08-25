<?php

namespace DpdConnect\Sdk\Objects;

use DpdConnect\Sdk\Api\Data\Response\ItemStatusInterface;
use DpdConnect\Sdk\Api\ShipmentLabelInterface;

/**
 * Class ShipmentLabel
 *
 * @package DpdConnect\Sdk\Objects
 */
class ShipmentLabel extends BaseObject implements ShipmentLabelInterface
{
    /**
     * @var ItemStatusInterface
     */
    protected $status;

    /**
     * @var string
     */
    protected $sequenceNumber;

    /**
     * @var string
     */
    protected $trackingNumber;

    /**
     * @var string
     */
    protected $label;

    /**
     * @var string
     */
    protected $returnLabel;

    /**
     * @var string
     */
    protected $exportLabel;

    /**
     * @var string
     */
    protected $codLabel;

    /**
     * @return ItemStatusInterface
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getSequenceNumber()
    {
        return $this->sequenceNumber;
    }

    /**
     * @return string
     */
    public function getTrackingNumber()
    {
        return $this->trackingNumber;
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @return string
     */
    public function getReturnLabel()
    {
        return $this->returnLabel;
    }

    /**
     * @return string
     */
    public function getExportLabel()
    {
        return $this->exportLabel;
    }

    /**
     * @return string
     */
    public function getCodLabel()
    {
        return $this->codLabel;
    }

    /**
     * @return array|string[]
     */
    public function getAllLabels()
    {
        return array_filter(
            [
                $this->label,
                $this->exportLabel,
                $this->returnLabel,
                $this->codLabel,
            ]
        );
    }
}
