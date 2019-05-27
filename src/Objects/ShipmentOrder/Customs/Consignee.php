<?php

namespace DpdConnect\Sdk\Objects\ShipmentOrder;

use DpdConnect\Sdk\Api\Data\ShipmentOrder\ConsigneeInterface;
use DpdConnect\Shipping\Model\ShipmentOrder\Contact\Address;
use JsonSerializable;

class Consignee extends Address implements JsonSerializable, ConsigneeInterface
{
}
