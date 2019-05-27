<?php

namespace DpdConnect\Sdk\Objects\ShipmentOrder\Shipment;

use DpdConnect\Sdk\Objects\BaseObject;
use JsonSerializable;

class Pickup extends BaseObject implements JsonSerializable, PickupInterface
{
    /**
     * @var mixed
     */
    protected $dateTimeFrom1;

    /**
     * @var mixed
     */
    protected $dateTimeTo1;

    /**
     * @var mixed
     */
    protected $dateTimeFrom2;

    /**
     * @var mixed
     */
    protected $dateTimeTo2;
}
