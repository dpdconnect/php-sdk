<?php

namespace DpdConnect\Sdk\Objects\ShipmentOrder\Customs;

use DpdConnect\Sdk\Api\Data\ShipmentOrder\Customs\Customs\ConsigneeInterface;
use DpdConnect\Sdk\Objects\ShipmentOrder\Contact\Address;
use JsonSerializable;

/**
 * Class Consignee
 *
 * @package DpdConnect\Sdk\Objects\ShipmentOrder
 */
class Consignee extends Address implements JsonSerializable, ConsigneeInterface
{
}
