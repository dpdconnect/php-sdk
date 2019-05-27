<?php

namespace DpdConnect\Sdk\Model\Request;

use DpdConnect\Sdk\Api\ShipmentOrderInterface;
use DpdConnect\Sdk\Exceptions\ValidationException;
use DpdConnect\Sdk\Objects\ObjectFactory;
use DpdConnect\Sdk\Objects\ShipmentAsync;
use DpdConnect\Sdk\Objects\ShipmentOrder;
use DpdConnect\Sdk\Objects\ShipmentOrder\Shipment;
use DpdConnect\Sdk\Objects\ShipmentOrder\Contact\Sender;
use DpdConnect\Sdk\Objects\ShipmentOrder\Contact\Receiver;
use DpdConnect\Sdk\Objects\ShipmentOrder\Shipment\Product;
use DpdConnect\Sdk\Objects\ShipmentOrder\Shipment\Customs;
use DpdConnect\Sdk\Objects\ShipmentOrder\Shipment\Parcel;
use DpdConnect\Sdk\Objects\ShipmentOrder\Shipment\Notification;
use DpdConnect\Sdk\Objects\ShipmentOrder\PrintOptions;
use DpdConnect\Shipping\Webservice\Model\Request\Type\PackageRequestType;
use DpdConnect\Shipping\Webservice\Model\Request\Type\ShipmentRequestType;

class RequestMapper
{
    /**
     * @return mixed
     */
    private static function getPrintOptions()
    {
        return ObjectFactory::create(PrintOptions::class, [
            'printerLanguage'   => 'PDF',
            'paperFormat'       => 'A4',
            'verticalOffset'    => (int) 1,
            'horizontalOffset'  => (int) 1,
        ]);
    }

    /**
     * @param $request
     * @return mixed
     */
    private static function getSender($request)
    {
        return ObjectFactory::create(Sender::class, [
            'companyname'   => $request['shipper_contact_company_name'],
            'name1'         => $request['shipper_contact_person_first_name'] . " " . $request['shipper_contact_person_last_name'],
            'street'        => $request['shipper_address_street'],
            'housenumber'   => '9',
            'postalcode'    => $request['shipper_address_postal_code'],
            'city'          => $request['shipper_address_city'],
            'country'       => $request['shipper_address_country_code'],
            'email'         => $request['shipper_email'],
            'phoneNumber'   => $request['shipper_contact_phone_number'],
            'faxNumber'     => $request['shipper_contact_fax_number'],
            'comment'       => '',
            'globalLocationNumber'  => 0,
            'commercialAddress'     => true,
            'floor'                 => '',
            'building'              => '',
            'department'            => '',
            'doorcode'              => '',
            'vatnumber'             => '',
            'eorinumber'            => 'string'
        ]);
    }

    /**
     * @param $request
     * @return mixed
     */
    private static function getReceiver($request)
    {
        $commerical = false;
        $companyName = "";
        if (isset($request['recipient_contact_company_name'])) {
            $commerical = true;
            $companyName = $request['recipient_contact_company_name'];
        }

        return ObjectFactory::create(Receiver::class, [
            'companyname'   => $request['recipient_contact_company_name'],
            'name1'         => $request['recipient_contact_person_first_name'] . " " . $request['recipient_contact_person_last_name'],
            'street'        => $request['recipient_address_street'],
            'housenumber'   => '9',
            'postalcode'    => $request['recipient_address_postal_code'],
            'city'          => $request['recipient_address_city'],
            'country'       => $request['recipient_address_country_code'],
            'email'         => $request['recipient_email'],
            'phoneNumber'   => $request['recipient_contact_phone_number'],
            'commercialAddress' => $commerical,
        ]);
    }

    /**
     * @param $request
     * @return array
     */
    private static function getParcels($request)
    {
        $parcels[] = ObjectFactory::create(Parcel::class, [
            'customerReferences' => ['sadsadsadasdsd'],
            'volume' => '000010000',
            'weight' => 100,
        ]);

        return $parcels;
    }

    private static function getProduct($request)
    {
        if ($request->getIsReturn()) {
            $code = 'RETURN';
        } else {
            return 'CL';
        }
    }

    /**
     * @param $request
     * @return array
     */
    private static function getShipments($request)
    {
        $shipments[] = ObjectFactory::create(Shipment::class, [
            'orderId' => 'jiasjdsoidj',
            'sendingDepot' => '0522',
            'sender' => self::getSender($request),
            'receiver' => self::getReceiver($request),
            'product' => [
                'productCode' => self::getProduct($request),
            ],
            'parcels' => self::getParcels($request)
        ]);

        return $shipments;
    }

    /**
     * @param \DpdConnect\Shipping\Model\ShipmentOrderInterface $shipmentOrder
     * @return ShipmentRequestType
     */
    public function mapShipmentOrder(ShipmentOrderInterface $shipmentOrder)
    {
        $request = [];
        $packageTypes = [];

        $receiverType = $this->getReceiver($shipmentOrder->getReceiver());

        foreach ($shipmentOrder->getPackages() as $package) {
            $customsDetailsType = $this->getExportDocument($package);
            $packageDetailsType = $this->getPackageDetails(
                $shipmentOrder->getShipmentDetails(),
                $package,
                $shipmentOrder->getSequenceNumber()
            );
            $packageType = new PackageRequestType(
                $receiverType,
                $packageDetailsType,
                $customsDetailsType
            );
            $packageTypes[] = $packageType;
        }

        $printOptions = self::getPrintOptions($request);
        $shipments = self::getShipments($request);

        $shipmentType = ObjectFactory::create(ShipmentOrder::class, [
            'printOptions' => $printOptions,
            'createLabel' => true,
            'shipments' => $shipments
        ]);

        return $shipmentType;
    }

    /**
     * @param ShipmentRequest $request
     * @param string $sequenceNumber
     *
     * @return ShipmentOrderInterface
     * @throws ValidationException
     */
    public static function mapShipmentRequest($request, $sequenceNumber)
    {
        $printOptions = self::getPrintOptions($request);

        $shipmentOrder = ObjectFactory::create(Shipment::class, [
            'orderId' => 'jiasjdsoidj',
            'sendingDepot' => '0522',
            'sender' => self::getSender($request),
            'receiver' => self::getReceiver($request),
            'product' => [
                'productCode' => 'CL',
            ],
            'parcels' => self::getParcels($request)
        ]);

        return $shipmentOrder;
    }


    public static function mapShipmentOrderRequest($shipmentOrders, $async = true, $url = false)
    {
        $printOptions = self::getPrintOptions();

        if (false === $async) {
            $shipmentOrderRequest = ObjectFactory::create(ShipmentOrder::class, [
                'printOptions' => $printOptions,
                'createLabel' => true,
                'shipments' => $shipmentOrders
            ]);

            return $shipmentOrderRequest;
        }

        $shipmentOrderRequest = ObjectFactory::create(ShipmentOrder::class, [
            'printOptions' => $printOptions,
            'createLabel' => true,
            'shipments' => $shipmentOrders
        ]);

        $shipmentOrderAsyncRequest = ObjectFactory::create(ShipmentAsync::class, [
            'callbackURI' => 'https://final-dpd.test/dpd/callback/push/?asdsad=asdasdsad',
            'label'       => $shipmentOrderRequest,
        ]);

        return $shipmentOrderAsyncRequest;

    }
}
