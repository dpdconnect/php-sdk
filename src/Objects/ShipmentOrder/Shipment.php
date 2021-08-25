<?php

namespace DpdConnect\Sdk\Objects\ShipmentOrder;

use DateTimeInterface;
use DpdConnect\Sdk\Objects\BaseObject;
use DpdConnect\Sdk\Objects\ShipmentOrder\Contact\Receiver;
use DpdConnect\Sdk\Objects\ShipmentOrder\Contact\Sender;
use DpdConnect\Sdk\Objects\ShipmentOrder\Shipment\Customs;
use DpdConnect\Sdk\Objects\ShipmentOrder\Shipment\Notification;
use DpdConnect\Sdk\Objects\ShipmentOrder\Shipment\Parcel;
use DpdConnect\Sdk\Objects\ShipmentOrder\Shipment\Product;
use JsonSerializable;

/**
 * Class Shipment
 *
 * @package DpdConnect\Sdk\Objects\ShipmentOrder
 */
class Shipment extends BaseObject implements JsonSerializable
{
    /**
     * @var ?string
     */
    protected $sendingDepot;

    /**
     * @var ?string
     */
    protected $volume;

    /**
     * @var integer|null
     */
    protected $weight;

    /**
     * @var string[]
     */
    protected $customerReferences = [];

    /**
     * @var DateTimeInterface|null
     */
    protected $expectedSendingDateTime;

    /**
     * @var Sender
     */
    protected $sender;

    /**
     * @var Receiver
     */
    protected $receiver;

    /**
     * @var Product
     */
    protected $product;

    /**
     * @var Parcel[]
     */
    protected $parcels;

    /**
     * @var Notification[]
     */
    protected $notifications = [];

    /**
     * @var Customs
     */
    protected $customs;

    /**
     * @return mixed
     */
    public function getSendingDepot()
    {
        return $this->sendingDepot;
    }

    /**
     * @param mixed $sendingDepot
     *
     * @return Shipment
     */
    public function setSendingDepot($sendingDepot)
    {
        $this->sendingDepot = $sendingDepot;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVolume()
    {
        return $this->volume;
    }

    /**
     * @param mixed $volume
     *
     * @return Shipment
     */
    public function setVolume($volume)
    {
        $this->volume = $volume;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @param int|null $weight
     *
     * @return Shipment
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * @return string[]
     */
    public function getCustomerReferences()
    {
        return $this->customerReferences;
    }

    /**
     * @param string[] $customerReferences
     *
     * @return Shipment
     */
    public function setCustomerReferences(array $customerReferences)
    {
        $this->customerReferences = $customerReferences;

        return $this;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getExpectedSendingDateTime()
    {
        return $this->expectedSendingDateTime;
    }

    /**
     * @param DateTimeInterface|null $expectedSendingDateTime
     *
     * @return Shipment
     */
    public function setExpectedSendingDateTime($expectedSendingDateTime)
    {
        $this->expectedSendingDateTime = $expectedSendingDateTime;

        return $this;
    }

    /**
     * @return Sender
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * @param Sender $sender
     *
     * @return Shipment
     */
    public function setSender(Sender $sender)
    {
        $this->sender = $sender;

        return $this;
    }

    /**
     * @return Receiver
     */
    public function getReceiver()
    {
        return $this->receiver;
    }

    /**
     * @param Receiver $receiver
     *
     * @return Shipment
     */
    public function setReceiver(Receiver $receiver)
    {
        $this->receiver = $receiver;

        return $this;
    }

    /**
     * @return Product
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @param Product $product
     *
     * @return Shipment
     */
    public function setProduct(Product $product)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * @return Parcel[]
     */
    public function getParcels()
    {
        return $this->parcels;
    }

    /**
     * @param Parcel[] $parcels
     *
     * @return Shipment
     */
    public function setParcels(array $parcels)
    {
        $this->parcels = $parcels;

        return $this;
    }

    /**
     * @return Notification[]
     */
    public function getNotifications()
    {
        return $this->notifications;
    }

    /**
     * @param Notification[] $notifications
     *
     * @return Shipment
     */
    public function setNotifications(array $notifications)
    {
        $this->notifications = $notifications;

        return $this;
    }

    /**
     * @return Customs
     */
    public function getCustoms()
    {
        return $this->customs;
    }

    /**
     * @param Customs $customs
     *
     * @return Shipment
     */
    public function setCustoms(Customs $customs)
    {
        $this->customs = $customs;

        return $this;
    }
}
