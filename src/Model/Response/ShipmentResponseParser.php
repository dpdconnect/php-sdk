<?php

namespace DpdConnect\Sdk\Model\Response;

use DpdConnect\Sdk\Objects\ObjectFactory;
use DpdConnect\Sdk\Objects\ResourceResponse;
use DpdConnect\Sdk\Objects\Response\CreateShipment\LabelInterface;
use DpdConnect\Sdk\Objects\Response\Generic\ResponseStatusInterface;
use DpdConnect\Sdk\Objects\ShipmentLabel;
use Exception;

/**
 * Class ShipmentResponseParser
 *
 * @package DpdConnect\Sdk\Model\Response
 */
class ShipmentResponseParser implements ResponseParserInterface
{
    /**
     * @param ResourceResponse $response
     *
     * @return LabelInterface[]
     * @throws Exception
     */
    public static function parseShipmentResponse($response)
    {
        $labels = [];

        $content = $response->getContent();
        if (!empty($content)) {
            if (key_exists('labelResponses', $content)) {
                $items = $content['labelResponses'];
                foreach ($items as $i => $item) {
                    $label = ObjectFactory::create(
                        ShipmentLabel::class,
                        [
                            'sequenceNumber' => 1,
                            'status' => ResponseStatusInterface::STATUS_SUCCESS,
                            'trackingNumber' => $item['parcelNumbers'],
                            'label' => base64_decode($item['label']),
                        ]
                    );

                    $labels[$i] = $label;
                }

                return $labels;
            } else {
                return $content;
            }
        }
    }
}
