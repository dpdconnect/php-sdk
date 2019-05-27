<?php

namespace DpdConnect\Sdk\Objects\ShipmentOrder;

use DpdConnect\Sdk\Api\Data\ShipmentOrder\ConsignorInterface;
use DpdConnect\Shipping\Model\ShipmentOrder\Contact\Address;
use JsonSerializable;

class Consignor extends Address implements JsonSerializable, ConsignorInterface
{
}
