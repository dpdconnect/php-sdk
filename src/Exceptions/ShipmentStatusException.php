<?php

namespace DpdConnect\Sdk\Exceptions;

class ShipmentStatusException extends ApiException
{
    /**
     * @param ShipmentOrderResponse $response
     *
     * @return static
     */
    public static function create($message)
    {
//        if ($response->getCreationState()) {
//            /** @var CreationState $creationState */
//            foreach ($response->getCreationState() as $creationState) {
//                $status = $creationState->getLabelData()->getStatus();
//                $messages[] = sprintf('%s %s', $status->getStatusText(), implode(' ', $status->getStatusMessage()));
//            }
//        } else {
//            $status = $response->getStatus();
//            $messages[] = sprintf('%s %s', $status->getStatusText(), implode(' ', $status->getStatusMessage()));
//        }

//        $message = implode(' ', $messages);
        return new static($message);
    }
}
