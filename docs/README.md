<!--
DOCS_METADATA:
  generated_at: 2026-02-19T12:49:04Z
  git_hash: ad2d32b
  tool_version: 1.0.0
  source_command: /create-documentation
-->

<!-- AUTO-GENERATED:START - Do not edit manually -->

# DPD Connect PHP SDK

A PHP SDK for integrating with the [DPD Connect API](https://api.dpdconnect.nl). Supports creating shipments, retrieving parcelshop locations, tracking parcels, managing labels, and more.

## Requirements

| Requirement | Version |
|-------------|---------|
| PHP | `>=7.4` |
| ext-json | `*` |
| ext-curl | `*` |

PHP 7.4 is supported for the DPD PrestaShop 1.7 module. It is end of life and gets no
security updates, so use a supported PHP version where you can.

## Installation

Install via Composer:

```bash
composer require dpdconnect/php-sdk
```

## Quick Start

### 1. Build a client

```php
use DpdConnect\Sdk\ClientBuilder;

$clientBuilder = new ClientBuilder();

// Authenticate by username + password
$client = $clientBuilder->buildAuthenticatedByPassword('your-username', 'your-password');

// Or authenticate by JWT token directly
$client = $clientBuilder->buildAuthenticatedByJwtToken('your-jwt-token');
```

### 2. Create a shipment

```php
use DpdConnect\Sdk\Objects\ObjectFactory;
use DpdConnect\Sdk\Objects\ShipmentOrder;
use DpdConnect\Sdk\Objects\ShipmentOrder\Contact\Sender;
use DpdConnect\Sdk\Objects\ShipmentOrder\Contact\Receiver;
use DpdConnect\Sdk\Objects\ShipmentOrder\PrintOptions;
use DpdConnect\Sdk\Objects\ShipmentOrder\Shipment;
use DpdConnect\Sdk\Objects\ShipmentOrder\Shipment\Parcel;

// Build shipment order using objects
$printOptions = ObjectFactory::create(PrintOptions::class, [
    'printerLanguage' => 'PDF',
    'paperFormat'     => 'A4',
]);

$sender = ObjectFactory::create(Sender::class, [
    'companyname'      => 'My Company B.V.',
    'name1'            => 'John Do',
    'street'           => 'John Do Street',
    'housenumber'      => '9',
    'postalcode'       => '1101BM',
    'city'             => 'Amsterdam',
    'country'          => 'NL',
    'email'            => 'info@mycompany.com',
    'phoneNumber'      => '0612345678',
    'commercialAddress'=> true,
]);

$receiver = ObjectFactory::create(Receiver::class, [
    'name1'            => 'Jane Do',
    'street'           => 'Jane Do Street',
    'housenumber'      => '10',
    'postalcode'       => '1101BM',
    'city'             => 'Amsterdam',
    'country'          => 'NL',
    'phoneNumber'      => '0698765432',
    'commercialAddress'=> false,
]);

$parcels = [ObjectFactory::create(Parcel::class, [
    'customerReferences' => ['order-12345'],
    'weight'             => 500,  // grams
])];

$shipment = ObjectFactory::create(Shipment::class, [
    'orderId'      => 'order-12345',
    'sendingDepot' => '0522',
    'sender'       => $sender,
    'receiver'     => $receiver,
    'product'      => ['productCode' => 'CL'],
    'parcels'      => $parcels,
]);

$shipmentOrder = ObjectFactory::create(ShipmentOrder::class, [
    'printOptions' => $printOptions,
    'createLabel'  => true,
    'shipments'    => [$shipment],
]);

// Send to API
$response = $client->getShipment()->createShipmentOrder($shipmentOrder);
```

### 3. Find parcelshops

```php
// List parcelshops near a location
$parcelshops = $client->getParcelshop()->getList([
    'longitude'  => 52.992,
    'latitude'   => 6.565,
    'countryIso' => 'NL',
    'limit'      => 10,
]);

// Get a specific parcelshop by ID
$parcelshop = $client->getParcelshop()->get('NL10566');
```

### 4. Track a parcel

```php
// Get parcel status by parcel ID
$status = $client->getParcel()->getStatus('parcel-id-here');

// Get parcel label by parcel ID
$label = $client->getParcel()->getLabel('parcel-id-here');
```

## Client API Overview

| Method | Returns | Description |
|--------|---------|-------------|
| `$client->getShipment()` | `Shipment` | Create shipments and labels |
| `$client->getParcelshop()` | `Parcelshop` | Find parcelshop locations |
| `$client->getParcel()` | `Parcel` | Track parcels and retrieve labels |
| `$client->getCountries()` | `Country` | List available countries |
| `$client->getProduct()` | `Product` | List available DPD products |
| `$client->getJob()` | `Job` | Poll async job status |
| `$client->getToken()` | `Token` | Manage JWT tokens |

## Custom API Endpoint

By default the SDK connects to `https://api.dpdconnect.nl`. To use a different endpoint (e.g. for testing):

```php
$clientBuilder = new ClientBuilder('https://api.staging.dpdconnect.nl');
$client = $clientBuilder->buildAuthenticatedByPassword('username', 'password');
```

## Documentation Index

| Document | Description |
|----------|-------------|
| [ARCHITECTURE.md](ARCHITECTURE.md) | SDK architecture and design patterns |
| [AUTHENTICATION.md](AUTHENTICATION.md) | Authentication methods |
| [RESOURCES.md](RESOURCES.md) | API resources reference |
| [OBJECTS.md](OBJECTS.md) | Domain objects and data models |
| [EXCEPTIONS.md](EXCEPTIONS.md) | Exception hierarchy and error handling |
| [CACHING.md](CACHING.md) | Caching system and custom backends |

<!-- AUTO-GENERATED:END -->

<!-- MANUAL:START - Safe to edit, preserved on updates -->
<!-- Add custom notes, integration tips, or project-specific details below -->

<!--
  Note for whoever regenerates the table above: CONTRIBUTING.md is deliberately not
  published to the GitHub mirror (it is excluded in .gitlab-ci.yml), so its row was
  removed by hand. If the generator adds it back, remove it again — on GitHub the
  link 404s.
-->

<!-- MANUAL:END -->
