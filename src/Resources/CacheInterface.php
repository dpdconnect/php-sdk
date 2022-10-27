<?php

namespace DpdConnect\Sdk\Resources;

interface CacheInterface
{
    /**
     * @param string $key
     * @param $data
     * @param int $expire
     * @return mixed
     */
    public function setCache($key, $data, $expire);

    /**
     * @param string $key
     * @return mixed
     */
    public function getCache($key);
}