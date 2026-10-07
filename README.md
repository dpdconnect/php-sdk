<div align="center">

<img src="https://img.shields.io/badge/DPD-Connect-d40000?style=for-the-badge&labelColor=1a1a1a" alt="DPD Connect" />

<h1>DPD Connect PHP SDK</h1>

<img src="https://img.shields.io/badge/PHP-7.4%2B-8892BF?logo=php&logoColor=white" alt="PHP" />
<img src="https://img.shields.io/badge/Type-Library-555555" alt="Type: Library" />
<img src="https://img.shields.io/badge/License-OSL--3.0-4B8BBE" alt="License: OSL-3.0" />
<img src="https://img.shields.io/badge/Version-1.0.5-brightgreen" alt="Version: 1.0.5" />

<br><br>

<strong>Connect your PHP application to DPD shipping services.</strong><br>
Create shipments, generate labels, find Parcelshop pickup points, and track parcels — all via a clean, dependency-free PHP library.

<br><br>

<a href="#-features">Features</a> ·
<a href="#-requirements">Requirements</a> ·
<a href="#-installation">Installation</a> ·
<a href="#-quick-start">Quick Start</a> ·
<a href="#-documentation">Documentation</a> ·
<a href="#-development">Development</a>

</div>

---

## 📦 Features

### 🚚 Shipment Creation

| Feature | Description |
|---------|-------------|
| **Synchronous** | Create shipments and receive labels in a single request |
| **Asynchronous** | Submit large batches and poll for completion via the Job resource |
| **Batch creation** | Send multiple shipment orders in one call |
| **Array or objects** | Build requests as plain arrays or typed domain objects |
| **Request mapping** | Built-in mapper converts Magento/custom requests to API objects |

### 🏷️ Label Generation

| Feature | Description |
|---------|-------------|
| **PDF labels** | Standard A4 and A6 paper formats |
| **ZPL labels** | Thermal printer language support |
| **Print offsets** | Configurable vertical and horizontal offsets |
| **Parcel label number** | Optionally pre-assign label numbers |

### 🏪 Parcelshop Lookup

| Feature | Description |
|---------|-------------|
| **Geolocation search** | Find parcelshops by longitude, latitude and country |
| **Lookup by ID** | Retrieve a specific parcelshop by its DPD ID |
| **Result limiting** | Control the number of results returned |

### 📬 Parcel Tracking

| Feature | Description |
|---------|-------------|
| **Status tracking** | Retrieve current parcel status by parcel ID |
| **Label retrieval** | Fetch a label for an existing parcel by ID |
| **Async job polling** | Check the state of asynchronous shipment creation jobs |

### 🔐 Authentication

| Feature | Description |
|---------|-------------|
| **Password auth** | Authenticate with username + password — JWT is fetched automatically |
| **JWT auth** | Provide your own JWT token directly |
| **Token caching** | Token cached until near expiry (5-minute safety margin) |
| **Token callback** | Register a callback to persist refreshed tokens externally |

### 💾 Caching

| Feature | Description |
|---------|-------------|
| **Built-in filesystem cache** | Countries and products cached for 1 hour with no setup required |
| **Stale fallback** | Product list falls back to a year-old cached result on API failure |
| **Custom backends** | Implement `CacheInterface` to use Redis, Memcached, or any store |

### 🌍 International Shipping

| Feature | Description |
|---------|-------------|
| **Customs declarations** | Consignee, consignor, customs lines with HS codes and values |
| **Cash on delivery** | COD amount, currency and purpose |
| **Notifications** | Email or SMS delivery notifications for the receiver |
| **Pickup configuration** | Optional pickup scheduling |

---

## ✅ Requirements

| Requirement | Version |
|-------------|---------|
| PHP | `>=7.4` |
| ext-json | `*` |
| ext-curl | `*` |

No framework dependency. Works standalone in any PHP project.

PHP 7.4 is supported so the DPD PrestaShop 1.7 module can install the SDK. It is end of
life and gets no security updates, so use a supported PHP version where you can. CI
checks the syntax of `src/` on 7.4 on every commit, but the test suite runs on 8.1 and
8.5 only; see [`docs/ci-php-version-matrix.md`](docs/ci-php-version-matrix.md).

---

## 📥 Installation

```bash
composer require dpdconnect/php-sdk
```

---

## ⚡ Quick Start

### 1. Build a client

```php
use DpdConnect\Sdk\ClientBuilder;

$clientBuilder = new ClientBuilder();

// Authenticate by username + password (JWT is fetched automatically)
$client = $clientBuilder->buildAuthenticatedByPassword('your-username', 'your-password');

// Or authenticate with an existing JWT token
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

$printOptions = ObjectFactory::create(PrintOptions::class, [
    'printerLanguage' => 'PDF',
    'paperFormat'     => 'A4',
]);

$sender = ObjectFactory::create(Sender::class, [
    'companyname'       => 'My Company B.V.',
    'name1'             => 'John Do',
    'street'            => 'John Do Street',
    'housenumber'       => '9',
    'postalcode'        => '1101BM',
    'city'              => 'Amsterdam',
    'country'           => 'NL',
    'email'             => 'info@mycompany.com',
    'phoneNumber'       => '0612345678',
    'commercialAddress' => true,
]);

$receiver = ObjectFactory::create(Receiver::class, [
    'name1'             => 'Jane Do',
    'street'            => 'Jane Do Street',
    'housenumber'       => '10',
    'postalcode'        => '1101BM',
    'city'              => 'Amsterdam',
    'country'           => 'NL',
    'phoneNumber'       => '0698765432',
    'commercialAddress' => false,
]);

$parcel = ObjectFactory::create(Parcel::class, [
    'customerReferences' => ['order-12345'],
    'weight'             => 500,
]);

$shipment = ObjectFactory::create(Shipment::class, [
    'orderId'      => 'order-12345',
    'sendingDepot' => '0522',
    'sender'       => $sender,
    'receiver'     => $receiver,
    'product'      => ['productCode' => 'CL'],
    'parcels'      => [$parcel],
]);

$shipmentOrder = ObjectFactory::create(ShipmentOrder::class, [
    'printOptions' => $printOptions,
    'createLabel'  => true,
    'shipments'    => [$shipment],
]);

$response = $client->getShipment()->createShipmentOrder($shipmentOrder);
```

### 3. Find Parcelshops

```php
// List parcelshops near a location
$parcelshops = $client->getParcelshop()->getList([
    'longitude'  => 4.9041,
    'latitude'   => 52.3676,
    'countryIso' => 'NL',
    'limit'      => 10,
]);

// Get a specific parcelshop by ID
$parcelshop = $client->getParcelshop()->get('NL10566');
```

### 4. Track a parcel

```php
$status = $client->getParcel()->getStatus('parcel-id');
$label  = $client->getParcel()->getLabel('parcel-id');
```

### 5. Use a custom API endpoint

```php
// For staging or self-hosted environments
$clientBuilder = new ClientBuilder('https://api.staging.dpdconnect.nl');
$client = $clientBuilder->buildAuthenticatedByPassword('username', 'password');
```

---

## 📚 Documentation

| Document | Description |
|----------|-------------|
| [Architecture](docs/ARCHITECTURE.md) | SDK architecture, HTTP stack, design patterns |
| [Authentication](docs/AUTHENTICATION.md) | Auth methods, token caching, token callback |
| [Resources](docs/RESOURCES.md) | All API resources with full method reference |
| [Objects](docs/OBJECTS.md) | Domain objects and data model reference |
| [Exceptions](docs/EXCEPTIONS.md) | Exception hierarchy and error handling patterns |
| [Caching](docs/CACHING.md) | Caching system and custom backend guide |

---

## 🛠️ Development

### Run tests

```bash
composer install
vendor/bin/phpunit -c phpunit.xml.dist
```

### Code quality

```bash
php bin/phpcs          # PHP_CodeSniffer
php bin/phplint        # PHP lint check
phpmd . text phpmd.xml --exclude vendor
```

### CI Pipeline

The project uses GitLab CI with four stages:

| Stage | Jobs | Description |
|-------|------|-------------|
| `validate` | `composer-validate`, `composer-audit` | Validates `composer.json` and checks advisories |
| `analyse` | `phpcs`, `lint-php74`, `phplint` | Static analysis; `lint-php74` syntax-checks `src/` on PHP 7.4, `phplint` runs on PHP 8.1 and 8.5 |
| `test` | `phpunit` | Full unit test suite on PHP 8.1 and 8.5 |
| `sync` | `sync-to-github` | On a release tag only: mirrors to GitHub and publishes the release |

`phplint` and `phpunit` run on PHP 8.1 and 8.5: 8.1 is the floor of the tested range,
and 8.5 catches runtime deprecations no static check sees. The declared floor of 7.4 is
covered separately by `lint-php74`, which is a syntax check only, because the test
toolchain cannot run on 7.4.
`sync-to-github` runs on release tags only; the job's own comments explain what it does
and why.

---

## 📄 License

[OSL-3.0](https://opensource.org/licenses/OSL-3.0) · © DPD — [pluginsupport@dpd.nl](mailto:pluginsupport@dpd.nl)
