<?php

namespace DpdConnect\Sdk\Objects\ShipmentOrder\Contact;

use DpdConnect\Sdk\Api\Data\ShipmentOrder\Contact\SenderInterface;
use JsonSerializable;

class Sender extends Address implements JsonSerializable, SenderInterface
{
}
