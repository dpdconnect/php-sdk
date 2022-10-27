<?php

namespace DpdConnect\Sdk\Objects\ShipmentOrder\Customs;

use DpdConnect\Sdk\Api\Data\ShipmentOrder\Customs\Customs\CustomsLineInterface;
use DpdConnect\Sdk\Objects\BaseObject;
use JsonSerializable;

/**
 * Class CustomsLine
 *
 * @package DpdConnect\Sdk\Objects\ShipmentOrder\Customs
 */
class CustomsLine extends BaseObject implements JsonSerializable, CustomsLineInterface
{
    /**
     * @var string
     */
    protected $description;

    /**
     * @var string
     */
    protected $harmonizedSystemCode;

    /**
     * @var string
     */
    protected $originCountry;

    /**
     * @var int
     */
    protected $quantity;

    /**
     * @var float $totalAmont
     */
    protected $totalAmount;

    /**
     * @var int
     */
    protected $netWeight;

    /**
     * @var int
     */
    protected $grossWeight;

    /**
     * @var int
     */
    protected $customsLineNumber;

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     *
     * @return CustomsLine
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string
     */
    public function getHarmonizedSystemCode()
    {
        return $this->harmonizedSystemCode;
    }

    /**
     * @param string $harmonizedSystemCode
     *
     * @return CustomsLine
     */
    public function setHarmonizedSystemCode($harmonizedSystemCode)
    {
        $this->harmonizedSystemCode = $harmonizedSystemCode;

        return $this;
    }

    /**
     * @return string
     */
    public function getOriginCountry()
    {
        return $this->originCountry;
    }

    /**
     * @param string $originCountry
     *
     * @return CustomsLine
     */
    public function setOriginCountry($originCountry)
    {
        $this->originCountry = $originCountry;

        return $this;
    }

    /**
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     *
     * @return CustomsLine
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * @return float
     */
    public function getTotalAmount()
    {
        return $this->totalAmount;
    }

    /**
     * @param float $totalAmount
     *
     * @return CustomsLine
     */
    public function setTotalAmount($totalAmount)
    {
        $this->totalAmount = $totalAmount;

        return $this;
    }

    /**
     * @return int
     */
    public function getNetWeight()
    {
        return $this->netWeight;
    }

    /**
     * @param int $netWeight
     *
     * @return CustomsLine
     */
    public function setNetWeight($netWeight)
    {
        $this->netWeight = $netWeight;

        return $this;
    }

    /**
     * @return int
     */
    public function getGrossWeight()
    {
        return $this->grossWeight;
    }

    /**
     * @param int $grossWeight
     *
     * @return CustomsLine
     */
    public function setGrossWeight($grossWeight)
    {
        $this->grossWeight = $grossWeight;

        return $this;
    }

    /**
     * @return int
     */
    public function getCustomsLineNumber()
    {
        return $this->customsLineNumber;
    }

    /**
     * @param int $customsLineNumber
     *
     * @return CustomsLine
     */
    public function setCustomsLineNumber($customsLineNumber)
    {
        $this->customsLineNumber = $customsLineNumber;

        return $this;
    }
}
