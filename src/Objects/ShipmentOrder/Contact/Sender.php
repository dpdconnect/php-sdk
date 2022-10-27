<?php

namespace DpdConnect\Sdk\Objects\ShipmentOrder\Contact;

use DpdConnect\Sdk\Api\Data\ShipmentOrder\Customs\Contact\SenderInterface;
use JsonSerializable;

/**
 * Class Sender
 *
 * @package DpdConnect\Sdk\Objects\ShipmentOrder\Contact
 */
class Sender extends Address implements JsonSerializable, SenderInterface
{
}
