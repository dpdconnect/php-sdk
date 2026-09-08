<?php

namespace DpdConnect\Sdk\Test;

use PHPUnit\Framework\Attributes\Depends;
use DpdConnect\Sdk\Objects\ObjectFactory;
use DpdConnect\Sdk\Objects\ShipmentOrder;
use DpdConnect\Sdk\Objects\ShipmentOrder\Contact\Receiver;
use DpdConnect\Sdk\Objects\ShipmentOrder\Contact\Sender;
use DpdConnect\Sdk\Objects\ShipmentOrder\PrintOptions;
use DpdConnect\Sdk\Objects\ShipmentOrder\Shipment\Parcel;
use PHPUnit\Framework\TestCase;

class ShipmentOrderTest extends TestCase
{
    private function getPrintOptions()
    {
        return ObjectFactory::create(PrintOptions::class, [
            'printerLanguage' => 'PDF',
            'paperFormat' => 'A4',
        ]);
    }

    private function getSender()
    {
        $sender = ObjectFactory::create(Sender::class, [
            'companyname' => 'Coding exprets B.V.',
            'contactPerson' => 'Armando Meeuwenoord',
            'name1' => 'Armando Meeuwenoord',
            'street' => 'Simonszand 9',
            'housenumber' => '9',
            'postalcode' => '2134ZX',
            'city' => 'Hoofddorp',
            'country' => 'NL',
            'email' => 'armando.meeuwenoord@gmail.com',
            'phoneNumber' => '061232323',
            'faxNumber' => '',
            'comment' => '',
            'globalLocationNumber' => 0,
            'commercialAddress' => true,
            'floor' => '',
            'building' => '',
            'department' => '',
            'doorcode' => '',
            'vatnumber' => '',
            'eorinumber' => 'string'
        ]);

        return $sender;
    }

    private function getReceiver()
    {
        $receiver = ObjectFactory::create(Receiver::class, [
            'companyname' => 'Coding exprets B.V.',
            'contactPerson' => 'Armando Meeuwenoord',
            'name1' => 'Armando Meeuwenoord',
            'street' => 'Simonszand 9',
            'housenumber' => '9',
            'postalcode' => '2134ZX',
            'city' => 'Hoofddorp',
            'country' => 'NL',
            'email' => 'armando.meeuwenoord@gmail.com',
            'phoneNumber' => '061232323',
            'commercialAddress' => true,
        ]);

        return $receiver;
    }

    private function getParcels()
    {
        $parcels[] = ObjectFactory::create(Parcel::class, [
            'customerReferences' => ['sadsadsadasdsd'],
            'volume' => '000010000',
            'weight' => 100,
        ]);

        return $parcels;
    }

    private function getShipments()
    {
        $shipments[] = ObjectFactory::create(ShipmentOrder\Shipment::class, [
            'orderId' => 'jiasjdsoidj',
            'sendingDepot' => '0522',
            'sender' => $this->getSender(),
            'receiver' => $this->getReceiver(),
            'product' => [
                'productCode' => 'CL',
            ],
            'parcels' => $this->getParcels()
        ]);

        return $shipments;
    }

    /**
     * Gets Object Instance with Json data filled in
     * @return Address
     */
    public function getObject()
    {
        $printOptions = $this->getPrintOptions();
        $shipments = $this->getShipments();

        return ObjectFactory::create(ShipmentOrder::class, [
            'printOptions' => $printOptions,
            'createLabel' => true,
            'shipments' => $shipments
        ]);
    }

    /**
     * @return ShipmentOrder
     */
    public function testGenerateShippingOrder()
    {
        /* $obj ShipmentOrder  */
        $shipmentOrder = $this->getObject();

        $this->assertNotNull($shipmentOrder);
        $this->assertTrue($shipmentOrder->isCreateLabel());
        return $shipmentOrder;
    }

    /**
     * @param ShipmentOrder $shipmentOrder
     */
    #[Depends('testGenerateShippingOrder')]
    public function testGetters($shipmentOrder)
    {
        $this->assertEquals($shipmentOrder->isCreateLabel(), true);
    }
}
