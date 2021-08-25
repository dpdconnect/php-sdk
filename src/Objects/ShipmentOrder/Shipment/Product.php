<?php

namespace DpdConnect\Sdk\Objects\ShipmentOrder\Shipment;

use DpdConnect\Sdk\Api\Data\ShipmentOrder\Shipment\ProductInterface;
use DpdConnect\Sdk\Objects\BaseObject;
use JsonSerializable;

/**
 * Class Product
 *
 * @package DpdConnect\Sdk\Objects\ShipmentOrder\Shipment
 */
class Product extends BaseObject implements JsonSerializable, ProductInterface
{
    /**
     * @var string
     */
    protected $productCode;

    /**
     * @var boolean|null
     */
    protected $homeDelivery;

    /**
     * @var boolean|null
     */
    protected $saturdayDelivery;

    /**
     * @var boolean|null
     */
    protected $tyres;

    /**
     * @var string|null
     */
    protected $parcelShopId;

    /**
     * @var ?Pickup
     */
    protected $pickup;

    /**
     * @return string
     */
    public function getProductCode()
    {
        return $this->productCode;
    }

    /**
     * @param string $productCode
     *
     * @return Product
     */
    public function setProductCode($productCode)
    {
        $this->productCode = $productCode;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getHomeDelivery()
    {
        return $this->homeDelivery;
    }

    /**
     * @param bool|null $homeDelivery
     *
     * @return Product
     */
    public function setHomeDelivery($homeDelivery)
    {
        $this->homeDelivery = $homeDelivery;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getSaturdayDelivery()
    {
        return $this->saturdayDelivery;
    }

    /**
     * @param bool|null $saturdayDelivery
     *
     * @return Product
     */
    public function setSaturdayDelivery($saturdayDelivery)
    {
        $this->saturdayDelivery = $saturdayDelivery;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getTyres()
    {
        return $this->tyres;
    }

    /**
     * @param bool|null $tyres
     *
     * @return Product
     */
    public function setTyres($tyres)
    {
        $this->tyres = $tyres;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getParcelShopId()
    {
        return $this->parcelShopId;
    }

    /**
     * @param string|null $parcelShopId
     *
     * @return Product
     */
    public function setParcelShopId($parcelShopId)
    {
        $this->parcelShopId = $parcelShopId;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPickup()
    {
        return $this->pickup;
    }

    /**
     * @param mixed $pickup
     *
     * @return Product
     */
    public function setPickup($pickup)
    {
        $this->pickup = $pickup;

        return $this;
    }
}
