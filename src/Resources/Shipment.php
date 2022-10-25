<?php

namespace DpdConnect\Sdk\Resources;

use DpdConnect\Sdk\Api\ShipmentLabelInterface;
use DpdConnect\Sdk\Api\ShipmentOrderInterface;
use DpdConnect\Sdk\Common\ResourceClient;
use DpdConnect\Sdk\Exceptions\DpdException;
use DpdConnect\Sdk\Exceptions\ShipmentValidationException;
use DpdConnect\Sdk\Model\Request\RequestMapper;
use DpdConnect\Sdk\Model\Response\ShipmentResponseParser;
use DpdConnect\Sdk\Objects\Response\ShipmentResponseCollection;
use Exception;
use InvalidArgumentException;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class Shipment extends BaseResource
{
    /**
     * @param bool $async
     *
     * @return string
     */
    protected function getUrl($async = false)
    {
        if (true === $async) {
            return 'api/connect/v1/shipment/async';
        }

        return 'api/connect/v1/shipment';

    }

    /**
     * @param       $object
     * @param array $query
     *
     * @return ResourceClient|int
     */
    public function create($object, $query = [])
    {
        if (is_null($object)) {
            throw new InvalidArgumentException('No shipment object given.');
        }

        $this->resourceClient->setResourceName($this->getUrl());

        return $this->resourceClient->createResource($query, $object);
    }

    /**
     * @param       $object
     * @param array $query
     *
     * @return ResourceClient|int
     */
    public function createAsync($object, $query = [])
    {
        if (is_null($object)) {
            throw new InvalidArgumentException('No shipment object given.');
        }

        $this->resourceClient->setResourceName($this->getUrl(true));

        return $this->resourceClient->createResource($query, $object);
    }

    /**
     * @param ShipmentOrderInterface[] $shipmentOrders
     *
     * @return ShipmentLabelInterface[]
     */
    public function createLabels(array $shipmentOrders)
    {
        $orders = [];

        foreach ($shipmentOrders as $sequenceNumber => $shipmentOrder) {
            $orders[$sequenceNumber] = $shipmentOrder;
        }
        if (!empty($orders)) {
            $labels = $this->createShipmentOrders($orders, false);
        } else {
            $labels = [];
        }

        return $labels;
    }

    /**
     * @param ShipmentOrderInterface $shipmentOrder
     *
     * @return ResourceClient|ShipmentResponseCollection|int
     */
    public function createShipmentOrder($shipmentOrder)
    {
        $this->resourceClient->setResourceName($this->getUrl());
        $response = $this->resourceClient->createResource([], $shipmentOrder);

        try {
            $labels = ShipmentResponseParser::parseShipmentResponse($response);
            $response = ShipmentResponseCollection::fromResponse($labels, []);
        } catch (Exception $exception) {
            $response = ShipmentResponseCollection::fromError($exception, []);
        }

        return $response;
    }

    /**
     * @param ShipmentOrderInterface $shipmentOrder
     *
     * @return ResourceClient|ShipmentResponseCollection|int
     */
    public function createShipmentOrderAsync($shipmentOrder)
    {
        $this->resourceClient->setResourceName($this->getUrl(true));
        $response = $this->resourceClient->createResource([], $shipmentOrder);

        try {
            $labels = ShipmentResponseParser::parseShipmentResponse($response);
            $response = ShipmentResponseCollection::fromResponse($labels, []);
        } catch (Exception $exception) {
            $response = ShipmentResponseCollection::fromError($exception, []);
        }

        return $response;
    }

    /**
     * @param ShipmentOrderInterface[] $shipmentOrders
     *
     * @return ShipmentLabelInterface[]
     */
    public function createShipmentOrders(array $shipmentOrders, $async = true)
    {
        $hipmentOrderRequest = RequestMapper::mapShipmentOrderRequest($shipmentOrders, $async);

        try {
            $this->resourceClient->setResourceName($this->getUrl($async));
            $response = $this->resourceClient->createResource([], $hipmentOrderRequest);
        } catch (Exception $e) {
            throw $this->setErrorByException($e);
        }

        return ShipmentResponseParser::parseShipmentResponse($response);
    }

    /**
     * @param array $shipmentRequests
     *
     * @return ShipmentResponseCollection
     */
    public function requestLabels(array $shipmentRequests)
    {
        /** @var ShipmentOrderInterface[] $shipmentOrders */
        $shipmentOrders = [];
        $invalidRequests = [];

        // convert M2 shipment request to api request, add sequence number
        foreach ($shipmentRequests as $sequenceNumber => $request) {
            try {
                $shipmentOrders[] = RequestMapper::mapShipmentRequest($request, $sequenceNumber);
            } catch (ShipmentValidationException $e) {
                $invalidRequests[$sequenceNumber] = $e->getMessage();
            }
        }

        // send shipment orders to APIs
        try {
            $labels = $this->createLabels($shipmentOrders);
            $response = ShipmentResponseCollection::fromResponse($labels, $invalidRequests);
        } catch (Exception $exception) { // ApiException
            $response = ShipmentResponseCollection::fromError($exception, $invalidRequests);
        }

        return $response;
    }

    /**
     * @param $dpdConnectException
     */
    private function setErrorByException($dpdConnectException)
    {
        if ($dpdConnectException instanceof DpdException) {
            $errorMessage = $dpdConnectException->getResponseErrors()[0]['message'];
            $errorNode = $dpdConnectException->getResponseErrors()[0]['metaDataPath'];
        } else {
            $errorMessage = $dpdConnectException->getMessage();
        }

        return new DpdException($errorMessage);
    }
}
