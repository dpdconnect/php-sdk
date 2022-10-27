<?php

namespace DpdConnect\Sdk\Objects\ShipmentOrder;

use DpdConnect\Sdk\Api\Data\ShipmentOrder\Customs\PrintOptionsInterface;
use DpdConnect\Sdk\Objects\BaseObject;
use JsonSerializable;

/**
 * Class PrintOptions
 *
 * @package DpdConnect\Sdk\Objects\ShipmentOrder
 */
class PrintOptions extends BaseObject implements JsonSerializable, PrintOptionsInterface
{
    /**
     * @var string
     */
    protected $printerLanguage;

    /**
     * @var string
     */
    protected $paperFormat;

    /**
     * @var int
     */
    protected $verticalOffset = 0;

    /**
     * @var int
     */
    protected $horizontalOffset = 0;

    /**
     * @return string
     */
    public function getPrinterLanguage()
    {
        return $this->printerLanguage;
    }

    /**
     * @param string $printerLanguage
     *
     * @return PrintOptions
     */
    public function setPrinterLanguage($printerLanguage)
    {
        $this->printerLanguage = $printerLanguage;

        return $this;
    }

    /**
     * @return string
     */
    public function getPaperFormat()
    {
        return $this->paperFormat;
    }

    /**
     * @param string $paperFormat
     *
     * @return PrintOptions
     */
    public function setPaperFormat($paperFormat)
    {
        $this->paperFormat = $paperFormat;

        return $this;
    }

    /**
     * @return int
     */
    public function getVerticalOffset()
    {
        return $this->verticalOffset;
    }

    /**
     * @param int $verticalOffset
     *
     * @return PrintOptions
     */
    public function setVerticalOffset($verticalOffset)
    {
        $this->verticalOffset = $verticalOffset;

        return $this;
    }

    /**
     * @return int
     */
    public function getHorizontalOffset()
    {
        return $this->horizontalOffset;
    }

    /**
     * @param int $horizontalOffset
     *
     * @return PrintOptions
     */
    public function setHorizontalOffset($horizontalOffset)
    {
        $this->horizontalOffset = $horizontalOffset;

        return $this;
    }
}
