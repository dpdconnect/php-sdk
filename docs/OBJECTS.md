<!--
DOCS_METADATA:
  generated_at: 2026-02-19T12:49:04Z
  git_hash: ad2d32b
  tool_version: 1.0.0
  source_command: /create-documentation
-->

<!-- AUTO-GENERATED:START - Do not edit manually -->

# Domain Objects

All domain objects extend `BaseObject` and are created using `ObjectFactory::create()`.

## Creating Objects

```php
use DpdConnect\Sdk\Objects\ObjectFactory;
use DpdConnect\Sdk\Objects\ShipmentOrder;

$order = ObjectFactory::create(ShipmentOrder::class, [
    'createLabel' => true,
    // ...
]);
```

## BaseObject (`src/Objects/BaseObject.php`)

The base class for all domain objects. Implements `JsonSerializable`.

**Key behaviours:**
- Constructor accepts an associative array and maps keys to typed properties (if they exist) or to `$dynamicProperties` (for unknown fields).
- `__call` and `__get` transparently proxy to both typed properties and the dynamic bag.
- `jsonSerialize()` returns only non-null values from `$dynamicProperties`, producing clean JSON.

---

## ShipmentOrder (`src/Objects/ShipmentOrder.php`)

The top-level shipment request object.

```php
use DpdConnect\Sdk\Objects\ShipmentOrder;
use DpdConnect\Sdk\Objects\ObjectFactory;

$order = ObjectFactory::create(ShipmentOrder::class, [
    'printOptions' => $printOptions,  // PrintOptions object
    'createLabel'  => true,
    'shipments'    => [$shipment],    // array of Shipment objects
]);
```

| Property | Type | Description |
|----------|------|-------------|
| `printOptions` | `PrintOptions` | Label printing settings |
| `createLabel` | `bool` | Whether to generate a label |
| `shipments` | `Shipment[]` | One or more shipment records |

---

## PrintOptions (`src/Objects/ShipmentOrder/PrintOptions.php`)

```php
use DpdConnect\Sdk\Objects\ShipmentOrder\PrintOptions;

$printOptions = ObjectFactory::create(PrintOptions::class, [
    'printerLanguage'  => 'PDF',   // PDF or ZPL
    'paperFormat'      => 'A4',    // A4 or A6
    'verticalOffset'   => 0,
    'horizontalOffset' => 0,
]);
```

---

## Shipment (`src/Objects/ShipmentOrder/Shipment.php`)

Represents a single shipment within an order.

```php
use DpdConnect\Sdk\Objects\ShipmentOrder\Shipment;

$shipment = ObjectFactory::create(Shipment::class, [
    'orderId'      => 'order-12345',
    'sendingDepot' => '0522',
    'sender'       => $sender,
    'receiver'     => $receiver,
    'product'      => ['productCode' => 'CL'],
    'parcels'      => [$parcel],
    // optional:
    'notifications'=> [$notification],
    'customs'      => $customs,
    'pickup'       => $pickup,
]);
```

| Property | Type | Description |
|----------|------|-------------|
| `orderId` | `string` | Your internal order reference |
| `sendingDepot` | `string` | DPD depot code |
| `sender` | `Sender` | Sender contact info |
| `receiver` | `Receiver` | Receiver contact info |
| `product` | `array\|Product` | Product code (e.g. `CL`) |
| `parcels` | `Parcel[]` | One or more parcel objects |
| `notifications` | `Notification[]` | Optional notifications |
| `customs` | `Customs` | Optional customs declaration |
| `pickup` | `Pickup` | Optional pickup info |

---

## Sender (`src/Objects/ShipmentOrder/Contact/Sender.php`)

```php
use DpdConnect\Sdk\Objects\ShipmentOrder\Contact\Sender;

$sender = ObjectFactory::create(Sender::class, [
    'companyname'         => 'My Company B.V.',
    'name1'               => 'John Do',
    'street'              => 'John Do Street',
    'housenumber'         => '9',
    'postalcode'          => '1101BM',
    'city'                => 'Amsterdam',
    'country'             => 'NL',
    'email'               => 'info@mycompany.com',
    'phoneNumber'         => '0612345678',
    'commercialAddress'   => true,
    // optional:
    'contactPerson'       => 'Jane Doe',
    'faxNumber'           => '',
    'comment'             => '',
    'globalLocationNumber'=> 0,
    'floor'               => '',
    'building'            => '',
    'department'          => '',
    'doorcode'            => '',
    'vatnumber'           => '',
    'eorinumber'          => '',
]);
```

---

## Receiver (`src/Objects/ShipmentOrder/Contact/Receiver.php`)

```php
use DpdConnect\Sdk\Objects\ShipmentOrder\Contact\Receiver;

$receiver = ObjectFactory::create(Receiver::class, [
    'name1'             => 'Jane Do',
    'street'            => 'Jane Do Street',
    'housenumber'       => '10',
    'postalcode'        => '1101BM',
    'city'              => 'Amsterdam',
    'country'           => 'NL',
    'phoneNumber'       => '0698765432',
    'commercialAddress' => false,
    // optional:
    'companyname'       => '',
    'email'             => 'jane@example.com',
]);
```

---

## Parcel (`src/Objects/ShipmentOrder/Shipment/Parcel.php`)

```php
use DpdConnect\Sdk\Objects\ShipmentOrder\Shipment\Parcel;

$parcel = ObjectFactory::create(Parcel::class, [
    'weight'             => 500,                    // weight in grams
    'customerReferences' => ['order-12345'],        // array of references
    'volume'             => '000010000',            // optional
    // optional:
    'parcelLabelNumber'  => '12345678',
]);
```

---

## Customs Objects

For international shipments outside the EU.

### Consignee (`src/Objects/ShipmentOrder/Customs/Consignee.php`)
### Consignor (`src/Objects/ShipmentOrder/Customs/Consignor.php`)
### CustomsLine (`src/Objects/ShipmentOrder/Customs/CustomsLine.php`)

```php
use DpdConnect\Sdk\Objects\ShipmentOrder\Customs\CustomsLine;

$customsLine = ObjectFactory::create(CustomsLine::class, [
    'customsContent'   => 'T-Shirts',
    'customsValue'     => 2999,          // value in cents
    'customsCurrency'  => 'EUR',
    'customsQuantity'  => 3,
    'customsNetWeight' => 200,
    'customsHsCode'    => '6109.10',
    'customsCountryOfOrigin' => 'NL',
]);
```

---

## Notification (`src/Objects/ShipmentOrder/Shipment/Notification.php`)

Email or SMS notification for the receiver.

```php
use DpdConnect\Sdk\Objects\ShipmentOrder\Shipment\Notification;

$notification = ObjectFactory::create(Notification::class, [
    'subject' => 'notify',
    'channel' => 'EMAIL',
    'value'   => 'receiver@example.com',
]);
```

---

## CashOnDelivery (`src/Objects/ShipmentOrder/Shipment/CashOnDelivery.php`)

```php
use DpdConnect\Sdk\Objects\ShipmentOrder\Shipment\CashOnDelivery;

$cod = ObjectFactory::create(CashOnDelivery::class, [
    'amount'   => 2999,    // amount in cents
    'currency' => 'EUR',
    'purpose'  => 'order-12345',
]);
```

---

## ShipmentLabel (`src/Objects/ShipmentLabel.php`)

Returned in `ShipmentLabelInterface[]` after successful shipment creation.

| Method | Returns | Description |
|--------|---------|-------------|
| `getLabelPdf()` | `string` | Base64-encoded PDF label data |
| `getParcelNumber()` | `string` | DPD parcel number |
| `getTrackingUrl()` | `string` | Tracking URL |

---

## MetaData (`src/Objects/MetaData.php`)

Optional metadata sent with every request as HTTP headers.

```php
use DpdConnect\Sdk\Objects\MetaData;
use DpdConnect\Sdk\Objects\ObjectFactory;

$meta = ObjectFactory::create(MetaData::class, [
    'webshopType'    => 'Magento',
    'webshopVersion' => '2.4.6',
    'pluginVersion'  => '1.0.0',
]);

$clientBuilder = new ClientBuilder(null, $meta);
```

Adds headers: `x-webshop-type`, `x-webshop-version`, `x-plugin-version` to all requests.

---

## ObjectFactory (`src/Objects/ObjectFactory.php`)

Simple static factory for creating `BaseObject` instances.

```php
ObjectFactory::create(ClassName::class, ['property' => 'value']);
// Equivalent to: new ClassName(['property' => 'value'])
```

<!-- AUTO-GENERATED:END -->

<!-- MANUAL:START - Safe to edit, preserved on updates -->
<!-- Add custom notes, team-specific information, or project-specific details below -->
<!-- MANUAL:END -->
