
**Parcelshops**
```
$clientBuilder = new ClientBuilder();
$client = $clientBuilder->buildAuthenticatedByPassword('admin', 'admin');


// get list of all parcelshops
$response = $client->getParcelshop()->list(['longitude' => 52.992, 'latitude' => 6.565, 'countryIso' => 'nl', 'limit' => 2]);

// get parcelshop by id
$response = $client->getParcelshop()->get('NL10566');

```

**Shipment**
```
$clientBuilder = new ClientBuilder();
$client = $clientBuilder->buildAuthenticatedByPassword('admin', 'admin');

// create shipment with data array
$response = $client->getShipment()->create([
    'printOptions' => [
        'printerLanguage' => 'PDF',
        'paperFormat' => 'A4'
    ],
    'createLabel' => true,
    'shipments' => [[
        'orderId' => "oasdsadsd",
        'sendingDepot' => "0522",
        'sender' => [
            'companyname' => 'DPD',
            'name1' => "John Do",
            'street' => "John Do Street 9",
            'country' => "NL",
            'postalcode' => "1101BM",
            'city' => "Amsterdam",
            'phone' => "06234234324",
            'email' => "info@johndo-bv.com",
            'commercialAddress' => true,
        ],
        'receiver' => [
            'name1' => "Jane Do",
            'street' => "Jane Do Street",
            'country' => "NL",
            'postalcode' => "1101BM",
            'city' => "Amsterdam",
            'phone' => "06134233434",
            'commercialAddress' => false
        ],
        'product' => [
            'productCode' => 'CL',
        ],
        "parcels" => [[
            'customerReferences' => ['sadsadsadasdsd'],
            'volume' => '000010000',
            'weight' => 100,
        ]],
    ]]
]);

// create shipmment with objects
private function getPrintOptions(ShipmentRequest $request)
{
    return ObjectFactory::create(PrintOptions::class, [
        'printerLanguage' => 'PDF',
        'paperFormat' => 'A4',
    ]);
}

private function getSender(ShipmentRequest $request)
{
    $sender = ObjectFactory::create(Sender::class, [
        'companyname' => 'John Do - B.V.',
        'name1' => 'John Do',
        'street' => 'John Do Street',
        'housenumber' => '9',
        'postalcode' => '1101BM',
        'city' => 'Hoofddorp',
        'country' => 'NL',
        'email' => 'info@johndo-bv.com',
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

private function getReceiver(ShipmentRequest $request)
{
    $receiver = ObjectFactory::create(Receiver::class, [
        'name1' => 'Jane Do',
        'street' => 'John Do Street',
        'housenumber' => '9',
        'postalcode' => '1101BM',
        'city' => 'Amsterdam',
        'country' => 'NL',
        'email' => 'info@johndo-bv.com',
        'phoneNumber' => '061232323',
        'commercialAddress' => false,
    ]);
    
    return $receiver;
}

private function getParcels(ShipmentRequest $request)
{
    $parcels[] = ObjectFactory::create(Parcel::class, [
    //            'parcelLabelNumber'    => '100',
        'customerReferences' => ['sadsadsadasdsd'],
        'volume' => '000010000',
        'weight' => 100,
    ]);
    
    return $parcels;
}

private function getShipments(ShipmentRequest $request)
{
    $shipments[] = ObjectFactory::create(ShipmentOrder\Shipment::class, [
        'orderId' => 'jiasjdsoidj',
        'sendingDepot' => '0522',
        'sender' => $this->getSender($request),
        'receiver' => $this->getReceiver($request),
        'product' => [
            'productCode' => 'CL',
        ],
        'parcels' => $this->getParcels($request)
    ]);
    
    return $shipments;
}

$printOptions = $this->getPrintOptions($request);
$shipments = $this->getShipments($request);

$shipmentOrder = ObjectFactory::create(ShipmentOrder::class, [
    'printOptions' => $printOptions,
    'createLabel' => true,
    'shipments' => $shipments
]);

```