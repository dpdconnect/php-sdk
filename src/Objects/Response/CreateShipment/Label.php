<?php

namespace DpdConnect\Sdk\Objects\Response\CreateShipment;

use DpdConnect\Sdk\Objects\Response\Generic\ItemStatusInterface;

/**
 * Class Label
 *
 * @package DpdConnect\Sdk\Objects\Response\CreateShipment
 */
class Label implements LabelInterface
{
    /**
     * @var ItemStatusInterface
     */
    private $status;

    /**
     * @var string
     */
    private $sequenceNumber;

    /**
     * @var string
     */
    private $trackingNumber;

    /**
     * @var string
     */
    private $label;

    /**
     * @var string
     */
    private $returnLabel;

    /**
     * @var string
     */
    private $exportLabel;

    /**
     * @var string
     */
    private $codLabel;

    /**
     * Label constructor.
     *
     * @param ItemStatusInterface $status
     * @param string              $sequenceNumber
     * @param string              $trackingNumber
     * @param string              $label
     * @param string              $returnLabel
     * @param string              $exportLabel
     * @param string              $codLabel
     */
    public function __construct(
        $status,
        $sequenceNumber,
        $trackingNumber,
        $label,
        $returnLabel,
        $exportLabel,
        $codLabel
    ) {
        $this->status = $status;
        $this->sequenceNumber = $sequenceNumber;
        $this->trackingNumber = $trackingNumber;
        $this->label = $label;
        $this->returnLabel = $returnLabel;
        $this->exportLabel = $exportLabel;
        $this->codLabel = $codLabel;
    }

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
