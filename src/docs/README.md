
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
            'companyname' => 'Coding exprets B.V.',
            'contactPerson' => 'Armando Meeuwenoord',
            'name1' => "Armando Meeuwenoord",
            'street' => "Simonszand 9",
            'country' => "NL",
            'postalcode' => "2134ZX",
            'city' => "Hoofddorp",
            'phone' => "06234234324",
            'email' => "armando.meeuwenoord@gmail.com",
            'commercialAddress' => true,
        ],
        'receiver' => [
            'name1' => "Armando Meeuwenoord",
            'street' => "Simonszand 9",
            'country' => "NL",
            'postalcode' => "2134ZX",
            'city' => "Hoofddorp",
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

private function getReceiver(ShipmentRequest $request)
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