<?php

namespace DpdConnect\Sdk\Objects;

class ObjectFactory
{
    public static function create($class, $data = [])
    {
        return new $class($data);
    }
}
