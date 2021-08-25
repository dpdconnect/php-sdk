<?php

namespace DpdConnect\Sdk\Objects\ShipmentOrder\Shipment;

use DpdConnect\Sdk\Api\Data\ShipmentOrder\Shipment\NotificationInterface;
use DpdConnect\Sdk\Objects\BaseObject;
use JsonSerializable;

/**
 * Class Notification
 *
 * @package DpdConnect\Sdk\Objects\ShipmentOrder\Shipment
 */
class Notification extends BaseObject implements JsonSerializable, NotificationInterface
{
    /**
     * @var string|null $subject
     */
    protected $subject;

    /**
     * @var string $channel
     */
    protected $channel;

    /**
     * @var string|null $channel
     */
    protected $value;

    /**
     * @var string|null $language
     */
    protected $language;
}
