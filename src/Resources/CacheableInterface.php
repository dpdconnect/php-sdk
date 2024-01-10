<?php

namespace DpdConnect\Sdk\Resources;

use DpdConnect\Sdk\CacheWrapper;

interface CacheableInterface
{
    /**
     * @param CacheWrapper $cacheWrapper
     */
    public function setCacheWrapper($cacheWrapper);
}
