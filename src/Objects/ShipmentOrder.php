<?php

namespace DpdConnect\Sdk\Objects;

use DpdConnect\Sdk\Objects\ShipmentOrder\PrintOptions;
use DpdConnect\Sdk\Objects\ShipmentOrder\Shipment;
use JsonSerializable;

/**
 * Class ShipmentOrder
 *
 * @package DpdConnect\Sdk\Objects
 */
class ShipmentOrder extends BaseObject implements JsonSerializable
{
    /**
     * @var PrintOptions
     */
    protected $printOptions;

    /**
     * @var bool
     */
    protected $createLabel = true;

    /**
     * @var Shipment[]
     */
    protected $shipments = [];

    /**
     * @return PrintOptions
     */
    public function getPrintOptions()
    {
        return $this->printOptions;
    }

    /**
     * @param PrintOptions $printOptions
     *
     * @return ShipmentOrder
     */
    public function setPrintOptions($printOptions)
    {
        $this->printOptions = $printOptions;

        return $this;
    }

    /**
     * @return bool
     */
    public function isCreateLabel()
    {
        return $this->createLabel;
    }

    /**
     * @param bool $createLabel
     *
     * @return ShipmentOrder
     */
    public function setCreateLabel($createLabel)
    {
        $this->createLabel = $createLabel;

        return $this;
    }

    /**
     * @return Shipment[]
     */
    public function getShipments()
    {
        return $this->shipments;
    }

    /**
     * @param Shipment[] $shipments
     *
     * @return ShipmentOrder
     */
    public function setShipments($shipments = [])
    {
        $this->shipments = $shipments;

        return $this;
    }
}
