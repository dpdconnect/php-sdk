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
    /**
     * BaseObject constructor.
     *
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        if (count($data) > 0) {
            foreach ($data as $key => $value) {
                $this->{$key} = $value;
            }
        }
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
                    $this->$key = $value;
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
        $properties = get_object_vars($this);
        $properties = array_filter($properties, static function ($value) {
             return $value === false || !empty($value);
         });

        return $properties;
    }
}
