<?php

namespace DpdConnect\Sdk\Objects\ShipmentOrder\Shipment;

use DpdConnect\Sdk\Objects\BaseObject;
use JsonSerializable;

/**
 * Class Pickup
 *
 * @package DpdConnect\Sdk\Objects\ShipmentOrder\Shipment
 */
class Pickup extends BaseObject implements JsonSerializable
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
