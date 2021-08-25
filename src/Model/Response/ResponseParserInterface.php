<?php

namespace DpdConnect\Sdk\Model\Response;

use DpdConnect\Sdk\Exceptions\ShipmentStatusException;
use DpdConnect\Sdk\Objects\ResourceResponse;
use DpdConnect\Sdk\Objects\Response\CreateShipment\LabelInterface;

/**
 * Interface ResponseParserInterface
 *
 * @package DpdConnect\Sdk\Model\Response
 */
interface ResponseParserInterface
{
    /**
     * @param ResourceResponse $response
     *
     * @return LabelInterface[]
     * @throws ShipmentStatusException
     */
    public static function parseShipmentResponse($response);
}
