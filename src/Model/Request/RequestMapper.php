<?php

namespace DpdConnect\Sdk\Model\Request;

use DpdConnect\Sdk\Api\ShipmentOrderInterface;
use DpdConnect\Sdk\Objects\ObjectFactory;
use DpdConnect\Sdk\Objects\ShipmentAsync;
use DpdConnect\Sdk\Objects\ShipmentOrder;
use DpdConnect\Sdk\Objects\ShipmentOrder\Contact\Receiver;
use DpdConnect\Sdk\Objects\ShipmentOrder\Contact\Sender;
use DpdConnect\Sdk\Objects\ShipmentOrder\Customs\CustomsLine;
use DpdConnect\Sdk\Objects\ShipmentOrder\PrintOptions;
use DpdConnect\Sdk\Objects\ShipmentOrder\Shipment;
use DpdConnect\Sdk\Objects\ShipmentOrder\Shipment\Customs;
use DpdConnect\Sdk\Objects\ShipmentOrder\Shipment\Parcel;
use DpdConnect\Sdk\Objects\ShipmentOrder\Shipment\Product;

/**
 * Class RequestMapper
 *
 * @package DpdConnect\Sdk\Model\Request
 */
class RequestMapper
{
    /**
     * @return mixed
     */
    private static function getPrintOptions($request = null)
    {
        if (is_null($request)) {
            return ObjectFactory::create(
                PrintOptions::class,
                [
                    'printerLanguage' => 'PDF',
                    'paperFormat' => 'A4',
                    'verticalOffset' => 1,
                    'horizontalOffset' => 1,
                ]
            );
        }

        return ObjectFactory::create(
            PrintOptions::class,
            [
                'printerLanguage' => 'PDF',
                'paperFormat' => $request['config']['label']['print_format'],
                'verticalOffset' => 1,
                'horizontalOffset' => 1,
            ]
        );
    }

    /**
     * @param $request
     *
     * @return mixed
     */
    private static function getSender($request)
    {
        if (empty($request['shipper_contact_person_first_name']) || empty($request['shipper_contact_person_last_name'])) {
            $name = $request['shipper_contact_person_name'];
        } else {
            $name = $request['shipper_contact_person_first_name']." ".$request['shipper_contact_person_last_name'];
        }

        return ObjectFactory::create(
            Sender::class,
            [
                'name1' => $request['shipper_contact_company_name'],
                'name2' => $name,
                'street' => $request['shipper_address_street'],
                'housenumber' => $request['shipper_address_street_number'],
                'postalcode' => $request['shipper_address_postal_code'],
                'city' => $request['shipper_address_city'],
                'country' => $request['shipper_address_country_code'],
                'email' => $request['shipper_email'],
                'phoneNumber' => $request['shipper_contact_phone_number'],
                'faxNumber' => $request['shipper_contact_fax_number'],
                'comment' => '',
                'globalLocationNumber' => 0,
                'commercialAddress' => true,
                'floor' => '',
                'building' => '',
                'department' => '',
                'doorcode' => '',
                'vatnumber' => '',
                'eorinumber' => 'string',
            ]
        );
    }

    /**
     * @param $request
     *
     * @return mixed
     */
    private static function getReceiver($request)
    {
        $commercial = false;
        if (isset($request['recipient_contact_company_name'])) {
            $commercial = true;
        }

        return ObjectFactory::create(
            Receiver::class,
            [
                'companyname' => $request['recipient_contact_company_name'],
                'name1' => $request['recipient_contact_person_first_name']." ".$request['recipient_contact_person_last_name'],
                'street' => $request['recipient_address_street'],
                'housenumber' => $request['recipient_address_street_number'],
                'postalcode' => $request['recipient_address_postal_code'],
                'city' => $request['recipient_address_city'],
                'country' => $request['recipient_address_country_code'],
                'email' => $request['recipient_email'],
                'phoneNumber' => $request['recipient_contact_phone_number'],
                'commercialAddress' => $commercial,
            ]
        );
    }

    /**
     * @param $request
     *
     * @return array
     */
    private static function getParcels($request)
    {
        $parcels = [];
        foreach ($request['packages'] as $i => $package) {
            $parcels[] = ObjectFactory::create(
                Parcel::class,
                [
                    'customerReferences' => [$request['order_shipment']->getOrder()->getIncrementId().' #'.$i],
                    'weight' => (int)round($request['order_shipment']->getOrder()->getWeight()),
                ]
            );
        }

        return $parcels;
    }

    /**
     * @param $request
     *
     * @return mixed
     */
    private static function getProduct($request)
    {
        if ($request->getIsReturn()) {
            $code = 'RETURN';
        } else {
            $code = 'CL';
        }

        return ObjectFactory::create(
            Product::class,
            [
                'productCode' => $code,
                'homeDelivery' => null,
                'saturdayDelivery' => null,
                'tyres' => null,
                'parcelShopId' => null,
                'pickup' => null,
            ]
        );
    }

    /**
     * @param $request
     *
     * @return mixed
     */
    private static function getCustoms($request)
    {
        $lines = [];

        $i = 0;
        foreach ($request['package_items'] as $item) {
            $i++;
            $lines[] = ObjectFactory::create(
                CustomsLine::class,
                [
                    // description of the content
                    'description' => $item['name'] ? $item['name'] : $request['params']['customs']['export_description'],
                    // customs tarif number
                    'harmonizedSystemCode' => (isset($item['customs_item_hs_code']) ? substr(
                        $item['customs_item_hs_code'],
                        0,
                        8
                    ) : ""),
                    // countrycode of invoice origin in ISO 3166-1 alpha-2 format
                    'originCountry' => (isset($item['item_origin_country']) ? $item['item_origin_country'] : "NL"),
                    // number of items in the parcel
                    'quantity' => (int)$item['qty'],
                    // gross weight in decagram (10 Grams) units without decimal delimiter
                    'grossWeight' => (int)round($item['weight']),
                    //  value of the article
                    'totalAmount' => (float)$item['price'] * $item['qty'],
                    // article ordering (line number of invoice)
                    'customsLineNumber' => $i,
                ]
            );
        }

        return ObjectFactory::create(
            Customs::class,
            [
                'description' => $request['params']['customs']['export_description'],
                'terms' => 'DAP',
                'reasonForExport' => 'SALE',
                'totalAmount' => ((float)$request['order_total_amount']),
                'totalCurrency' => $request['base_currency_code'],
                'consignee' => self::getSender($request),
                'consignor' => self::getReceiver($request),
                'customsLines' => $lines,
            ]
        );
    }

    /**
     * @param $request
     *
     * @return array
     */
    private static function getShipments($request)
    {
        return ObjectFactory::create(
            Shipment::class,
            [
                'orderId' => $request['order_shipment']->getOrderId(),
                'sendingDepot' => '0522',
                'weight' => (int)$request['package_weight'],
                'sender' => self::getSender($request),
                'notifications' => [],
                'receiver' => self::getReceiver($request),
                'product' => self::getProduct($request),
                'parcels' => self::getParcels($request),
                'customs' => self::getCustoms($request),
            ]
        );
    }

    /**
     * @param mixed  $request
     * @param string $sequenceNumber
     *
     * @return ShipmentOrderInterface
     */
    public static function mapShipmentRequest($request, $sequenceNumber, $async = false)
    {
        return ObjectFactory::create(
            Shipment::class,
            [
                'orderId' => $request['order_shipment']->getOrderId(),
                'sendingDepot' => '0522',
                'customerReferences' => [$request['order_shipment']->getOrder()->getIncrementId().' #1'],
                'weight' => (int)($request['package_weight'] * 100),
                'sender' => self::getSender($request),
                'notifications' => [],
                'receiver' => self::getReceiver($request),
                'product' => self::getProduct($request),
                'parcels' => self::getParcels($request),
                'customs' => self::getCustoms($request),
            ]
        );
    }

    /**
     * @param array $shipmentOrders
     * @param bool  $async
     * @param bool  $url
     *
     * @return mixed
     */
    public static function mapShipmentOrderRequest($shipmentOrders, $async = true, $url = false)
    {
        $printOptions = self::getPrintOptions();

        if (false === $async) {
            return ObjectFactory::create(
                ShipmentOrder::class,
                [
                    'printOptions' => $printOptions,
                    'createLabel' => true,
                    'shipments' => $shipmentOrders,
                ]
            );
        }

        $url = null;
        $shipments = [];
        foreach ($shipmentOrders as $shipmentOrder) {
            $shipments[] = self::getShipments($shipmentOrder);

            if (is_null($url)) {
                $url = $shipmentOrder->getAsyncCallback();
            }
        }

        $shipmentOrderRequest = ObjectFactory::create(
            ShipmentOrder::class,
            [
                'printOptions' => $printOptions,
                'createLabel' => true,
                'shipments' => $shipments,
            ]
        );

        $shipmentOrderAsyncRequest = ObjectFactory::create(
            ShipmentAsync::class,
            [
                'callbackURI' => $url,
                'label' => $shipmentOrderRequest,
            ]
        );

        return $shipmentOrderAsyncRequest;
    }
}
