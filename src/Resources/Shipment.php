<?php

namespace DpdConnect\Sdk\Resources;

use DpdConnect\Sdk\Api\ShipmentApi;
use DpdConnect\Sdk\Api\ShipmentOrderInterface;
use DpdConnect\Sdk\Common;
use DpdConnect\Sdk\Common\HttpClient;
use DpdConnect\Sdk\Common\ResourceClient;
use DpdConnect\Sdk\Exceptions\RequestException;
use DpdConnect\Sdk\Exceptions\ServerException;
use DpdConnect\Sdk\Model\Request\RequestMapper;
use DpdConnect\Sdk\Model\Response\ShipmentResponseParser;
use DpdConnect\Sdk\Objects\ShipmentOrder;
use DpdConnect\Shipping\Api\Data\ShipmentLabelInterface;
use DpdConnect\Shipping\DpdException;
use DpdConnect\Sdk\Objects\Response\CreateShipment\LabelInterface;
use DpdConnect\Sdk\Objects\Response\ShipmentResponseCollection;
use DpdConnect\Sdk\Objects\Response\ShipmentResponseInterface;
use Exception;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class Shipment extends BaseResource
{
    /**
     * @param ResourceClient $resourceClient
     */
    public function __construct(
        ResourceClient $resourceClient
    ) {
        parent::__construct($resourceClient);
    }

    /**
     * @param bool $async
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
     * @param $object
     * @param array $query
     * @return ResourceClient|int
     */
    public function create($object, $query = [])
    {
        if (is_null($object)) {
            throw new \InvalidArgumentException('No shipment object given.');
        }

        $this->resourceClient->setResourceName($this->getUrl());
        $response = $this->resourceClient->createResource($query, $object);

        return $response;
    }

    /**
     * @param ShipmentOrderInterface[] $shipmentOrders
     *
     * @return ShipmentLabelInterface[]
     * @throws RequestException
     * @throws ServerException
     */
    public function createLabels(array $shipmentOrders)
    {
        $orders = [];

        foreach ($shipmentOrders as $sequenceNumber => $shipmentOrder) {
            $orders[$sequenceNumber] = $shipmentOrder;
        }

        if (! empty($orders)) {
            $labels = $this->createShipmentOrders($orders);
        } else {
            $labels = [];
        }

        return $labels;
    }

    /**
     * @param ShipmentOrderInterface $shipmentOrder
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
    public function createShipmentOrders(array $shipmentOrders, $async = false)
    {
        $shipmentOrders = array_map(
            function ($shipmentOrder) {
                return $shipmentOrder;
//                return RequestMapper::mapShipmentOrder($shipmentOrder);
            },
            $shipmentOrders
        );

        $hipmentOrderRequest = RequestMapper::mapShipmentOrderRequest($shipmentOrders, $async);

        try {
            $this->resourceClient->setResourceName($this->getUrl());
            $response = $this->resourceClient->createResource([], $hipmentOrderRequest);
        } catch (Exception $e) {
            return ($this->setErrorByException($e));
        } catch (GlOperationException $e) {
            throw new ApiOperationException('API operation failed', 0, $e);
        } catch (GlCommunicationException $e) {
            throw new ApiCommunicationException('API communication failed', 0, $e);
        }

        return ShipmentResponseParser::parseShipmentResponse($response);
    }

    /**
     * @param array $shipmentRequests
     * @return ShipmentResponseCollection
     * @throws \DpdConnect\Sdk\Exceptions\ValidationException
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
        } catch (\Exception $exception) { // ApiException
            $response = ShipmentResponseCollection::fromError($exception, $invalidRequests);
        }

        return $response;
    }

    private function setErrorByException($dpdConnectException)
    {

            if ($dpdConnectException instanceof DpdException) {
            $errorMessage = $dpdConnectException->getResponseErrors()[0]['message'];
            $errorNode = $dpdConnectException->getResponseErrors()[0]['metaDataPath'];

            print_r($errorMessage);
            print_r($errorNode);
        } else {
            $errorMessage = $dpdConnectException->getMessage();
        }

        throw new DpdException($errorMessage);
        die;
    }
}
