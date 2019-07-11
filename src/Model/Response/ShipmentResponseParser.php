<?php

namespace DpdConnect\Sdk\Model\Response;

use DpdConnect\Sdk\Objects\ShipmentLabel;
use Exception;
use DpdConnect\Sdk\Objects\ObjectFactory;
use DpdConnect\Sdk\Objects\Response\Generic\ResponseStatusInterface;

class ShipmentResponseParser implements ResponseParserInterface
{
    /**
     * @param string $status
     * @return string
     */
    private static function getStatusCode($status)
    {
        if ($status === ResponseStatusInterface::STATUS_SUCCESS) {
            return ResponseStatusInterface::STATUS_SUCCESS;
        }

        return ResponseStatusInterface::STATUS_FAILURE;
    }

    /**
     * @param ResourceResponse $response
     *
     * @return LabelInterface[]
     * @throws Exception
     */
    public static function parseShipmentResponse($response)
    {
        $labels = [];

        $responseStatus = self::getStatusCode($response->getStatus());

        if (ResponseStatusInterface::STATUS_SUCCESS !== $responseStatus) {
            if ($response->hasErrors()) {
//                throw ShipmentStatusException::create($response->getContent()['message'], $responseStatus);
            }
        }


        if (ResponseStatusInterface::STATUS_PARTIAL === $responseStatus) {
            $errors = [];
        }

        $content = $response->getContent();
        if (!empty($content)) {
            if (key_exists('labelResponses', $content)) {
                    $items = $content['labelResponses'];
                    foreach ($items as $i => $item) {
                        $label = ObjectFactory::create(ShipmentLabel::class, [
                            'sequenceNumber' => 1,
                            'status' => ResponseStatusInterface::STATUS_SUCCESS,
                            'trackingNumber' => $item['parcelNumbers'],
                            'label' => base64_decode($item['label'])
                        ]);

                        $labels[$i] = $label;
                    }

                    return $labels;
                } else {
                    return $content;
                }
            }
    }
}
