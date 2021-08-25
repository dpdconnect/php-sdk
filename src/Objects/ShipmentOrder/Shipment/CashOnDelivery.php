<?php

namespace DpdConnect\Sdk\Objects\ShipmentOrder\Shipment;

use DpdConnect\Sdk\Api\Data\ShipmentOrder\Shipment\CashOnDeliveryInterface;
use DpdConnect\Sdk\Objects\BaseObject;
use JsonSerializable;

/**
 * Class CashOnDelivery
 *
 * @package DpdConnect\Sdk\Objects\ShipmentOrder\Shipment
 */
class CashOnDelivery extends BaseObject implements JsonSerializable, CashOnDeliveryInterface
{
    /**
     * @var float
     */
    protected $amount;

    /**
     * @var string
     */
    protected $currency;

    /**
     * @var string
     */
    protected $paymentMethod;
}
