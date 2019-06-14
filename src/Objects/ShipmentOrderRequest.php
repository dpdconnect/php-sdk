<?php

namespace Dhl\Shipping\Webservice\Schema\Bcs;

class ShipmentOrderRequest
{
    /**
     * @var ShipmentOrderType $ShipmentOrder
     */
    protected $ShipmentOrder;

    /**
     * @param Version           $Version
     * @param ShipmentOrderType $ShipmentOrder
     */
    public function __construct($Version, $ShipmentOrder)
    {
        $this->Version = $Version;
        $this->ShipmentOrder = $ShipmentOrder;
    }

    /**
     * @return Version
     */
    public function getVersion()
    {
        return $this->Version;
    }

    /**
     * @param Version $Version
     *
     * @return \Dhl\Shipping\Webservice\Schema\Bcs\CreateShipmentOrderRequest
     */
    public function setVersion($Version)
    {
        $this->Version = $Version;
        return $this;
    }

    /**
     * @return ShipmentOrderType
     */
    public function getShipmentOrder()
    {
        return $this->ShipmentOrder;
    }

    /**
     * @param ShipmentOrderType $shipmentOrder
     *
     * @return ShipmentOrderRequest
     */
    public function setShipmentOrder($shipmentOrder)
    {
        $this->shipmentOrder = $shipmentOrder;
        return $this;
    }

}