<!--
DOCS_METADATA:
  generated_at: 2026-02-19T12:49:04Z
  git_hash: ad2d32b
  tool_version: 1.0.0
  source_command: /create-documentation
-->

<!-- AUTO-GENERATED:START - Do not edit manually -->

# Exception Handling

## Exception Hierarchy

```
\Exception
└── DpdException                         # Base SDK exception
    ├── ApiException                     # Generic API-level errors
    ├── AuthenticateException            # HTTP 401 — invalid credentials / expired token
    ├── HttpException                    # cURL transport errors (network failure)
    ├── InvalidArgumentException         # Missing required argument
    ├── InvalidResponseException         # Unexpected response format
    ├── RequestException                 # API 4xx validation errors (wraps ResponseError)
    ├── ServerException                  # HTTP 500 — server-side errors
    ├── ShipmentStatusException          # Shipment status errors
    ├── ShipmentValidationException      # Shipment request validation failures
    └── ValidationException              # General validation errors
```

All exceptions live in `DpdConnect\Sdk\Exceptions\`.

---

## Exception Reference

### `DpdException` (`src/Exceptions/DpdException.php`)

Base exception for all SDK errors. Accepts a string, `ResponseError`, or another `Exception` as its `$error` argument.

```php
use DpdConnect\Sdk\Exceptions\DpdException;

try {
    $response = $client->getShipment()->createShipmentOrder($order);
} catch (DpdException $e) {
    echo $e->getMessage();
    $details = $e->getErrorDetails(); // raw error (ResponseError or original Exception)
}
```

### `AuthenticateException` (`src/Exceptions/AuthenticateException.php`)

Thrown when the API returns HTTP 401. This means credentials are wrong or the JWT token has expired.

```php
use DpdConnect\Sdk\Exceptions\AuthenticateException;

try {
    $response = $client->getShipment()->create($order);
} catch (AuthenticateException $e) {
    // Re-authenticate or check credentials
    echo 'Authentication failed: ' . $e->getMessage();
}
```

### `HttpException` (`src/Exceptions/HttpException.php`)

Thrown when a cURL error occurs (network unreachable, timeout, DNS failure, etc.).

```php
use DpdConnect\Sdk\Exceptions\HttpException;

try {
    $response = $client->getParcelshop()->getList([]);
} catch (HttpException $e) {
    echo 'Network error: ' . $e->getMessage(); // cURL error message
    echo 'cURL code: ' . $e->getCode();        // cURL error code
}
```

### `ServerException` (`src/Exceptions/ServerException.php`)

Thrown when the API returns HTTP 500, or when an invalid JSON response is received from the server.

```php
use DpdConnect\Sdk\Exceptions\ServerException;

try {
    $response = $client->getShipment()->create($order);
} catch (ServerException $e) {
    // Log and retry, or alert operations team
    echo 'Server error: ' . $e->getMessage();
}
```

### `RequestException` (`src/Exceptions/RequestException.php`)

Thrown when the API returns a 4xx response with validation errors. Wraps a `ResponseError` object.

```php
use DpdConnect\Sdk\Exceptions\RequestException;
use DpdConnect\Sdk\Common\ResponseError;

try {
    $response = $client->getShipment()->create($invalidOrder);
} catch (RequestException $e) {
    /** @var ResponseError $error */
    $error = $e->getMessage(); // Combined error string
    // Access field-level validation errors via the ResponseError
}
```

### `ShipmentValidationException` (`src/Exceptions/ShipmentValidationException.php`)

Thrown during the `requestLabels()` flow when a shipment request fails mapping validation (before being sent to the API). Caught per-shipment; other shipments in the batch still proceed.

### `InvalidArgumentException` (`src/Exceptions/InvalidArgumentException.php`)

Thrown when a required argument is `null` (e.g. no parcelshop ID provided, no shipment object given).

---

## Recommended Error Handling Pattern

```php
use DpdConnect\Sdk\Exceptions\AuthenticateException;
use DpdConnect\Sdk\Exceptions\HttpException;
use DpdConnect\Sdk\Exceptions\ServerException;
use DpdConnect\Sdk\Exceptions\RequestException;
use DpdConnect\Sdk\Exceptions\DpdException;

try {
    $response = $client->getShipment()->createShipmentOrder($shipmentOrder);

    if ($response->hasErrors()) {
        foreach ($response->getErrors() as $error) {
            // Handle per-shipment errors
        }
    }

} catch (AuthenticateException $e) {
    // Credentials invalid or token expired
    // → Re-authenticate, check config

} catch (HttpException $e) {
    // Network / transport error
    // → Retry after delay

} catch (ServerException $e) {
    // DPD API server error
    // → Log, alert, retry later

} catch (RequestException $e) {
    // Validation error in request data
    // → Fix input data, do not retry immediately

} catch (DpdException $e) {
    // Any other SDK error
    // → Log and investigate
}
```

---

## `ResponseError` (`src/Common/ResponseError.php`)

Helper class that parses validation error responses from the DPD Connect API.

Contains:
- `getErrorString()` — combined human-readable error message
- Per-field validation errors mapped from `_embedded` response data

<!-- AUTO-GENERATED:END -->

<!-- MANUAL:START - Safe to edit, preserved on updates -->
<!-- Add custom notes, team-specific information, or project-specific details below -->
<!-- MANUAL:END -->
