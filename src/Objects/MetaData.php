<?php

namespace DpdConnect\Sdk\Objects;

/**
 * Class MetaData
 *
 * @package DpdConnect\Sdk\Objects
 */
class MetaData extends BaseObject
{
    const DEFAULTVERSIONSTRING = 'UNKNOWN';

    /**
     * @var string
     */
    protected $webshopType;

    /**
     * @var string
     */
    protected $webshopVersion;

    /**
     * @var string
     */
    protected $pluginVersion;

    /**
     * @return string
     */
    public function getWebshopType()
    {
        return $this->webshopType ? $this->webshopType : self::DEFAULTVERSIONSTRING;
    }

    /**
     * @param string $webshopType
     *
     * @return MetaData
     */
    public function setWebshopType($webshopType)
    {
        $this->webshopType = $webshopType;

        return $this;
    }

    /**
     * @return string
     */
    public function getWebshopVersion()
    {
        return $this->webshopVersion ? $this->webshopVersion : self::DEFAULTVERSIONSTRING;
    }

    /**
     * @param string $webshopVersion
     *
     * @return MetaData
     */
    public function setWebshopVersion($webshopVersion)
    {
        $this->webshopVersion = $webshopVersion;

        return $this;
    }

    /**
     * @return string
     */
    public function getPluginVersion()
    {
        return $this->pluginVersion ? $this->pluginVersion : self::DEFAULTVERSIONSTRING;
    }

    /**
     * @param string $pluginVersion
     *
     * @return MetaData
     */
    public function setPluginVersion($pluginVersion)
    {
        $this->pluginVersion = $pluginVersion;

        return $this;
    }
}
