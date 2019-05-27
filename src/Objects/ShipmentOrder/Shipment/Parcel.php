<?php

namespace DpdConnect\Sdk\Objects\ShipmentOrder\Shipment;

use DpdConnect\Sdk\Api\Data\ShipmentOrder\Shipment\ParcelInterface;
use DpdConnect\Sdk\Objects\BaseObject;
use JsonSerializable;

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
    protected $cashOnDelivery;
}
