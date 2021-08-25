<?php

namespace DpdConnect\Sdk\Objects\ShipmentOrder\Contact;

use DpdConnect\Sdk\Api\Data\ShipmentOrder\Contact\ReceiverInterface;
use JsonSerializable;

/**
 * Class Receiver
 *
 * @package DpdConnect\Sdk\Objects\ShipmentOrder\Contact
 */
class Receiver extends Address implements JsonSerializable, ReceiverInterface
{
}
