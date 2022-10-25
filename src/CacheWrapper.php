<?php

namespace DpdConnect\Sdk;

use DpdConnect\Sdk\Resources\CacheInterface;

class CacheWrapper
{
    /** @var CacheInterface|null */
    public $cache;

    /**
     * @param CacheInterface|null $cache
     */
    public function __construct($cache = null)
    {
        $this->cache = $cache;
    }

    /**
     * @param $key
     * @param false $previous
     * @param string $prefix
     * @return false|mixed
     */
    public function getCachedList($key, $previous = false, $prefix = 'dpd')
    {
        // This is an hour
        $maxAge = 3600;

        if($previous) {
            // This is a year;
            $maxAge = 31556926;
        }

        // Check if implementation supports own caching
        if($this->cache instanceof CacheInterface) {
            return $this->cache->getCache($prefix .sha1(serialize($key)) . ($previous ? '_prev': ''));
        }

        // Fallback to SDK caching
        $filename = sys_get_temp_dir().'/dpd/'.sha1($prefix . date('Ymd').serialize($key));

        if (!file_exists($filename) || filesize($filename) == 0 || filemtime($filename) < time()-$maxAge) {
            return false;
        }

        return unserialize(file_get_contents($filename));
    }

    /**
     * @param $data
     * @param $key
     * @param string $prefix
     */
    public function storeCachedList($data, $key, $prefix = 'dpd')
    {
        // This is an hour
        $hour = 3600;
        // This is a year ;)
        $year = 31556926;

        // Check if implementation supports own caching
        if($this->cache instanceof CacheInterface) {
            $this->cache->setCache($prefix. sha1(serialize($key)), $data, $hour);
            $this->cache->setCache($prefix .sha1(serialize($key)). '_prev', $data, $year);

            return;
        }

        // Fallback to SDK caching
        if (!file_exists(sys_get_temp_dir().'/dpd/')) {
            mkdir(sys_get_temp_dir().'/dpd/');
        }

        $filename = sys_get_temp_dir().'/dpd/'.sha1($prefix.date('Ymd').serialize($key));
        file_put_contents($filename, serialize($data));
    }
}