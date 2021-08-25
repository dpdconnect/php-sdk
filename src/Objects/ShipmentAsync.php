<?php

namespace DpdConnect\Sdk\Objects;

use JsonSerializable;

/**
 * Class ShipmentAsync
 *
 * @package DpdConnect\Sdk\Objects
 */
class ShipmentAsync extends BaseObject implements JsonSerializable
{
    /**
     * @var string
     */
    protected $callbackURI;

    /**
     * @var ShipmentOrder
     */
    protected $label;

    /**
     * @return mixed
     */
    public function getCallbackURI()
    {
        return $this->callbackURI;
    }

    /**
     * @param mixed $callbackURI
     *
     * @return ShipmentAsync
     */
    public function setCallbackURI($callbackURI)
    {
        $this->callbackURI = $callbackURI;

        return $this;
    }

    /**
     * @return ShipmentOrder
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param ShipmentOrder $label
     *
     * @return ShipmentAsync
     */
    public function setLabel(ShipmentOrder $label)
    {
        $this->label = $label;

        return $this;
    }
}
