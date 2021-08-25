<?php

namespace DpdConnect\Sdk\Objects\ShipmentOrder\Customs;

use DpdConnect\Sdk\Api\Data\ShipmentOrder\Customs\ConsignorInterface;
use DpdConnect\Sdk\Objects\ShipmentOrder\Contact\Address;
use JsonSerializable;

/**
 * Class Consignor
 *
 * @package DpdConnect\Sdk\Objects\ShipmentOrder\Customs
 */
class Consignor extends Address implements JsonSerializable, ConsignorInterface
{
}
