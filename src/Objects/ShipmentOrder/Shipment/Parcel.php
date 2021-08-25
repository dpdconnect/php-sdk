<?php

namespace DpdConnect\Sdk\Objects\ShipmentOrder\Shipment;

use DpdConnect\Sdk\Api\Data\ShipmentOrder\Shipment\ParcelInterface;
use DpdConnect\Sdk\Objects\BaseObject;
use JsonSerializable;

/**
 * Class Parcel
 *
 * @package DpdConnect\Sdk\Objects\ShipmentOrder\Shipment
 */
class Parcel extends BaseObject implements JsonSerializable, ParcelInterface
{
    /**
     * @var string
     */
    protected $parcelLabelNumber;

    /**
     * @var string[]
     */
    protected $customerReferences = [];

    /**
     * @var string
     */
    protected $volume = "000000000";

    /**
     * @var int|null
     */
    protected $weight;

    /**
     * @var CashOnDelivery
     */
    protected $cod = false;

    /**
     * @var int|null
     */
    protected $goodsExpirationDate = null;

    /**
     * @var string|null
     */
    private $goodsDescription = null;

    /**
     * @return string
     */
    public function getParcelLabelNumber()
    {
        return $this->parcelLabelNumber;
    }

    /**
     * @param string $parcelLabelNumber
     *
     * @return Parcel
     */
    public function setParcelLabelNumber($parcelLabelNumber)
    {
        $this->parcelLabelNumber = $parcelLabelNumber;

        return $this;
    }

    /**
     * @return string[]
     */
    public function getCustomerReferences()
    {
        return $this->customerReferences;
    }

    /**
     * @param string[] $customerReferences
     *
     * @return Parcel
     */
    public function setCustomerReferences($customerReferences)
    {
        $this->customerReferences = $customerReferences;

        return $this;
    }

    /**
     * @return string
     */
    public function getVolume()
    {
        return $this->volume;
    }

    /**
     * @param string $volume
     *
     * @return Parcel
     */
    public function setVolume($volume)
    {
        $this->volume = $volume;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @param int|null $weight
     *
     * @return Parcel
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * @return CashOnDelivery
     */
    public function getCod()
    {
        return $this->cod;
    }

    /**
     * @param CashOnDelivery $cod
     *
     * @return Parcel
     */
    public function setCod($cod)
    {
        $this->cod = $cod;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getGoodsExpirationDate()
    {
        return $this->goodsExpirationDate;
    }

    /**
     * @param int|null $goodsExpirationDate
     *
     * @return Parcel
     */
    public function setGoodsExpirationDate($goodsExpirationDate)
    {
        $this->goodsExpirationDate = $goodsExpirationDate;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getGoodsDescription()
    {
        return $this->goodsDescription;
    }

    /**
     * @param string|null $goodsDescription
     *
     * @return Parcel
     */
    public function setGoodsDescription($goodsDescription)
    {
        $this->goodsDescription = $goodsDescription;

        return $this;
    }
}
