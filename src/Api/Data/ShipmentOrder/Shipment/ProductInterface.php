<?php

namespace DpdConnect\Sdk\Api\Data\ShipmentOrder\Shipment;

use DpdConnect\Sdk\Objects\ShipmentOrder\Shipment\Product;

interface ProductInterface
{
    /**
     * @return string
     */
    public function getProductCode();

    /**
     * @param string $productCode
     * @return Product
     */
    public function setProductCode($productCode);

    /**
     * @return bool|null
     */
    public function getHomeDelivery();

    /**
     * @param bool|null $homeDelivery
     * @return Product
     */
    public function setHomeDelivery($homeDelivery);

    /**
     * @return bool|null
     */
    public function getSaturdayDelivery();

    /**
     * @param bool|null $saturdayDelivery
     * @return Product
     */
    public function setSaturdayDelivery($saturdayDelivery);

    /**
     * @return bool|null
     */
    public function getTyres();

    /**
     * @param bool|null $tyres
     * @return Product
     */
    public function setTyres($tyres);

    /**
     * @return string|null
     */
    public function getParcelShopId();

    /**
     * @param string|null $parcelShopId
     * @return Product
     */
    public function setParcelShopId($parcelShopId);

    /**
     * @return mixed
     */
    public function getPickup();

    /**
     * @param mixed $pickup
     * @return Product
     */
    public function setPickup($pickup);
}
