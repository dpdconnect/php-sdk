<?php

namespace DpdConnect\Sdk\Objects\Customs;

use DpdConnect\Sdk\Api\Data\ShipmentOrder\Customs\CustomsLineInterface;
use DpdConnect\Sdk\Objects\BaseObject;
use JsonSerializable;

class CustomsLine extends BaseObject implements JsonSerializable, CustomsLineInterface
{
    /**
     * @var string
     */
    protected $description;

    /**
     * @var string
     */
    protected $harmonizedSystemCode;

    /**
     * @var string
     */
    protected $originCountry;

    /**
     * @var int
     */
    protected $quantity;

    /**
     * @var float $totalAmont
     */
    protected $totalAmount;

    /**
     * @var int
     */
    protected $netWeight;

    /**
     * @var int
     */
    protected $grossWeight;

    /**
     * @var int
     */
    protected $customsLineNumber;
}
