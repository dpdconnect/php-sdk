<!--
DOCS_METADATA:
  generated_at: 2026-02-19T12:49:04Z
  git_hash: ad2d32b
  tool_version: 1.0.0
  source_command: /create-documentation
-->

<!-- AUTO-GENERATED:START - Do not edit manually -->

# Authentication

The SDK supports two authentication strategies: **password-based** (username + password → JWT) and **direct JWT token**.

## Password-Based Authentication

The most common approach. The SDK exchanges your username and password for a JWT token via `POST /auth/login`, caches it until near-expiry, and automatically refreshes it.

```php
use DpdConnect\Sdk\ClientBuilder;

$clientBuilder = new ClientBuilder();
$client = $clientBuilder->buildAuthenticatedByPassword('your-username', 'your-password');
```

**Token lifecycle:**
- Token is fetched on the first API call.
- Cached in `CacheWrapper` (filesystem by default) under key `dpd_token`.
- Expires 5 minutes before actual JWT expiry to prevent short-lived-token issues.
- Refreshed automatically on the next request after expiry.

## JWT Token Authentication

Use this when you already have a valid token (e.g. obtained externally or from a previous session).

```php
use DpdConnect\Sdk\ClientBuilder;

$clientBuilder = new ClientBuilder();
$client = $clientBuilder->buildAuthenticatedByJwtToken('eyJ0eXAiOiJKV1QiLCJhbGciO...');
```

## Token Update Callback

If you manage token storage yourself (e.g. persisting to a database), register a callback on the `Authentication` object. It is called whenever a new token is fetched.

```php
use DpdConnect\Sdk\ClientBuilder;
use DpdConnect\Sdk\Common\Authentication;

$authentication = Authentication::fromPassword('username', 'password');
$authentication->setTokenUpdateCallback(function (string $newToken) {
    // Persist $newToken to your storage
    file_put_contents('/tmp/dpd_jwt.txt', $newToken);
});

// Build client manually using the authentication object
$clientBuilder = new ClientBuilder();
// The callback fires whenever the token is refreshed internally
```

## Fetching a Public JWT Token Directly

The `Token` resource allows fetching a raw JWT token without going through a full `Client`:

```php
use DpdConnect\Sdk\ClientBuilder;

$clientBuilder = new ClientBuilder();
$client = $clientBuilder->buildAuthenticatedByPassword('username', 'password');

$token = $client->getToken()->getPublicJWTToken('username', 'password');
// Returns the raw JWT string, or the raw response on failure
```

## How Token Validation Works

The `Token` resource checks whether a cached token is still valid before using it:

1. Splits the JWT into `header.payload.signature`.
2. Base64-decodes the payload.
3. Reads the `exp` claim.
4. Returns `false` if `time() >= exp - 300` (5-minute safety margin).

## Authentication Class Reference

**`DpdConnect\Sdk\Common\Authentication`** (`src/Common/Authentication.php`)

| Method | Description |
|--------|-------------|
| `Authentication::fromPassword($user, $pass)` | Static factory — creates authentication from credentials |
| `Authentication::fromJwtToken($token)` | Static factory — creates authentication from existing JWT |
| `getUsername(): string` | Returns stored username |
| `getPassword(): string` | Returns stored password |
| `getJwtToken(): string` | Returns current JWT token |
| `setJwtToken($token): $this` | Updates the stored JWT token |
| `setTokenUpdateCallback(callable): $this` | Registers callback on token refresh |

<!-- AUTO-GENERATED:END -->

<!-- MANUAL:START - Safe to edit, preserved on updates -->
<!-- Add custom notes, team-specific information, or project-specific details below -->
<!-- MANUAL:END -->
