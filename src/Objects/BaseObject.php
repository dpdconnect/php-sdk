<?php

namespace DpdConnect\Sdk\Objects;

use JsonSerializable;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 * @SuppressWarnings(PHPMD.NumberOfChildren)
 * @SuppressWarnings(PHPMD.TooManyFields)
 */
class BaseObject implements JsonSerializable
{
    protected $dynamicProperties = [];

    /**
     * BaseObject constructor.
     *
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        if (count($data) === 0) {
            return;
        }

        foreach ($data as $key => $value) {
            if(property_exists($this, $key)) {
                $this->$key = $value;
                continue;
            }
            $this->dynamicProperties[$key] = $value;
        }
    }

    public function __call($key, $arguments)
    {
        if(strpos($key, 'get') === 0) {
            $key = lcfirst(substr($key, 3));
        }
//        elseif (strpos($key, 'set') === 0) {
//            $key = lcfirst(substr($key, 3));
//        }

        if(property_exists($this, $key)) {
            return $this->$key;
        }

        if (array_key_exists($key, $this->dynamicProperties)) {
            return $this->dynamicProperties[$key];
        }

        return null;
    }

    public function __get($key)
    {
        if(property_exists($this, $key)) {
            return $this->$key;
        }

        if (array_key_exists($key, $this->dynamicProperties)) {
            return $this->dynamicProperties[$key];
        }

        return null;
    }

    /**
     * @param $object
     *
     * @return $this
     */
    public function loadFromArray($object)
    {
        if ($object) {
            foreach ($object as $key => $value) {
                if (property_exists($this, $key)) {
                    $this->dynamicProperties[$key] = $value;
                }
            }
        }

        return $this;
    }

    /**
     * @return array
     */
    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return array_filter($this->dynamicProperties);
    }
}
