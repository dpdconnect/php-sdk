<!--
DOCS_METADATA:
  generated_at: 2026-02-19T12:49:04Z
  git_hash: ad2d32b
  tool_version: 1.0.0
  source_command: /create-documentation
-->

<!-- AUTO-GENERATED:START - Do not edit manually -->

# API Resources

All resources are accessible through the `Client` object. Each resource corresponds to one or more DPD Connect API endpoints.

## Shipment (`src/Resources/Shipment.php`)

Access via `$client->getShipment()`.

### Methods

#### `create($object, $query = [])`

Low-level: sends a raw array or object to `POST /api/connect/v1/shipment`.

```php
$response = $client->getShipment()->create([
    'printOptions' => ['printerLanguage' => 'PDF', 'paperFormat' => 'A4'],
    'createLabel'  => true,
    'shipments'    => [[ /* ... */ ]],
]);
```

#### `createAsync($object, $query = [])`

Same as `create()` but posts to `POST /api/connect/v1/shipment/async`. Returns a job reference for polling.

```php
$response = $client->getShipment()->createAsync($shipmentOrderArray);
```

#### `createShipmentOrder(ShipmentOrderInterface $shipmentOrder)`

Recommended: accepts a typed `ShipmentOrder` object and returns a `ShipmentResponseCollection`.

```php
$response = $client->getShipment()->createShipmentOrder($shipmentOrder);

if ($response->hasErrors()) {
    foreach ($response->getErrors() as $error) {
        echo $error;
    }
} else {
    foreach ($response->getLabels() as $label) {
        echo $label->getLabelPdf(); // base64 PDF data
    }
}
```

#### `createShipmentOrderAsync(ShipmentOrderInterface $shipmentOrder)`

Same as `createShipmentOrder()` but uses the async endpoint.

#### `createShipmentOrders(array $shipmentOrders, $async = true)`

Batch method. Accepts an array of `ShipmentOrderInterface` instances.

```php
$labels = $client->getShipment()->createShipmentOrders([$order1, $order2], false);
```

Returns `ShipmentLabelInterface[]`.

#### `createLabels(array $shipmentOrders)`

Synchronous batch label creation (wraps `createShipmentOrders` with `$async = false`).

```php
$labels = $client->getShipment()->createLabels([$order1, $order2]);
```

#### `requestLabels(array $shipmentRequests)`

Maps raw Magento/custom shipment request arrays into `ShipmentOrder` objects via `RequestMapper`, then calls `createLabels`. Collects `ShipmentValidationException` failures per sequence number.

```php
$response = $client->getShipment()->requestLabels([
    0 => $magentoShipmentRequest1,
    1 => $magentoShipmentRequest2,
]);
// Returns ShipmentResponseCollection
```

---

## Parcelshop (`src/Resources/Parcelshop.php`)

Access via `$client->getParcelshop()`.

### Methods

#### `get($id)`

Fetch a single parcelshop by its ID from `GET /api/connect/v1/parcelshop/{id}`.

```php
$parcelshop = $client->getParcelshop()->get('NL10566');
```

#### `getList($query = [])`

List parcelshops near a location from `GET /api/connect/v1/parcelshop`.

```php
$parcelshops = $client->getParcelshop()->getList([
    'longitude'  => 52.3676,
    'latitude'   => 4.9041,
    'countryIso' => 'NL',
    'limit'      => 10,
]);
```

**Query parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `longitude` | float | Geographic longitude |
| `latitude` | float | Geographic latitude |
| `countryIso` | string | ISO 3166-1 alpha-2 country code |
| `limit` | int | Max number of results |

---

## Parcel (`src/Resources/Parcel.php`)

Access via `$client->getParcel()`.

### Methods

#### `getStatus($id)`

Retrieve current status of a parcel from `GET /api/connect/v1/parcel/status/{id}`.

```php
$status = $client->getParcel()->getStatus('1234567890');
```

#### `getLabel($id)`

Retrieve label for a parcel from `GET /api/connect/v1/parcel/label/{id}`.

```php
$label = $client->getParcel()->getLabel('1234567890');
```

---

## Country (`src/Resources/Country.php`)

Access via `$client->getCountries()`.

Results are cached (1 hour by default).

### Methods

#### `getList($query = [])`

Retrieve all supported countries from `GET /api/connect/v1/countries`.

```php
$countries = $client->getCountries()->getList();
```

---

## Product (`src/Resources/Product.php`)

Access via `$client->getProduct()`.

Results are cached (1 hour). On API failure, falls back to a previously cached result (up to 1 year).

### Methods

#### `getList($query = [])`

Retrieve available DPD products from `GET /api/connect/v1/available-products`.

```php
$products = $client->getProduct()->getList([
    'countryFrom' => 'NL',
    'countryTo'   => 'DE',
]);
```

On API failure with no stale cache: returns `[]`.

---

## Job (`src/Resources/Job.php`)

Access via `$client->getJob()`.

Use after creating a shipment with `createAsync()` to poll for completion.

### Methods

#### `getState($id)`

Get the current state of an async job from `GET /api/connect/v1/job/{id}`.

```php
$jobState = $client->getJob()->getState('job-id-returned-by-async');
```

---

## Token (`src/Resources/Token.php`)

Access via `$client->getToken()`.

### Methods

#### `getPublicJWTToken($username, $password)`

Fetch a public-scope JWT token. Returns cached token if still valid.

```php
$token = $client->getToken()->getPublicJWTToken('username', 'password');
```

---

## Caching in Resources

`Country` and `Product` resources implement `CacheableInterface`. They cache responses in `CacheWrapper`. See [CACHING.md](CACHING.md) for details on injecting a custom cache backend.

To inject a cache implementation:

```php
$client->setCacheCallable($myCacheImplementation);
```

All resources implementing `CacheableInterface` will receive the `CacheWrapper` automatically.

<!-- AUTO-GENERATED:END -->

<!-- MANUAL:START - Safe to edit, preserved on updates -->
<!-- Add custom notes, team-specific information, or project-specific details below -->
<!-- MANUAL:END -->
