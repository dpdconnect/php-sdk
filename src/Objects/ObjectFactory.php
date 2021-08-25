<?php

namespace DpdConnect\Sdk\Objects;

/**
 * Class ObjectFactory
 *
 * @package DpdConnect\Sdk\Objects
 */
class ObjectFactory
{
    /**
     * @param       $class
     * @param array $data
     *
     * @return mixed
     */
    public static function create($class, $data = [])
    {
        return new $class($data);
    }
}
