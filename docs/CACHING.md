<!--
DOCS_METADATA:
  generated_at: 2026-02-19T12:49:04Z
  git_hash: ad2d32b
  tool_version: 1.0.0
  source_command: /create-documentation
-->

<!-- AUTO-GENERATED:START - Do not edit manually -->

# Caching

The SDK has a built-in caching layer used for:
1. **JWT tokens** — cached per-user, refreshed near expiry.
2. **Country list** — cached for 1 hour.
3. **Product list** — cached for 1 hour; falls back to a year-old cache on API failure.

## Default: Filesystem Cache

By default, cached data is stored in temporary files under `sys_get_temp_dir()/dpd/`. Files are named using a SHA1 hash of the cache key and date.

**Cache TTL:**
- Normal cache: 1 hour (`3600` seconds)
- Previous/stale fallback: 1 year (`31556926` seconds)

No configuration is required to use the default cache.

---

## Custom Cache Backend

Implement `CacheInterface` to use your own cache backend (Redis, Memcached, database, etc.).

### Interface

**`DpdConnect\Sdk\Resources\CacheInterface`** (`src/Resources/CacheInterface.php`)

```php
interface CacheInterface
{
    /**
     * Retrieve a cached value.
     *
     * @param string $key
     * @return mixed|false  false if not found or expired
     */
    public function getCache(string $key);

    /**
     * Store a value in cache.
     *
     * @param string $key
     * @param mixed  $data
     * @param int    $ttl   TTL in seconds
     * @return void
     */
    public function setCache(string $key, $data, int $ttl): void;
}
```

### Example: Redis Implementation

```php
use DpdConnect\Sdk\Resources\CacheInterface;

class RedisCache implements CacheInterface
{
    private \Redis $redis;

    public function __construct(\Redis $redis)
    {
        $this->redis = $redis;
    }

    public function getCache(string $key)
    {
        $value = $this->redis->get($key);
        if ($value === false) {
            return false;
        }
        return unserialize($value);
    }

    public function setCache(string $key, $data, int $ttl): void
    {
        $this->redis->setex($key, $ttl, serialize($data));
    }
}
```

### Injecting the Custom Cache

```php
use DpdConnect\Sdk\ClientBuilder;

$redis = new \Redis();
$redis->connect('127.0.0.1', 6379);

$clientBuilder = new ClientBuilder();
$client = $clientBuilder->buildAuthenticatedByPassword('username', 'password');

// Inject cache into all CacheableInterface resources
$client->setCacheCallable(new RedisCache($redis));
```

The `setCacheCallable()` method on `Client` iterates over all resource properties and calls `setCacheWrapper()` on any that implement `CacheableInterface`.

---

## CacheWrapper (`src/CacheWrapper.php`)

The `CacheWrapper` bridges the SDK internals and the `CacheInterface`. It handles:
- Key generation (SHA1 hash of key + optional prefix)
- "Previous" (stale) cache keys for fallback (suffix `_prev`)
- Transparent delegation to either `CacheInterface` or the filesystem fallback

You do not need to interact with `CacheWrapper` directly unless building a custom resource.

---

## CacheableInterface (`src/Resources/CacheableInterface.php`)

Resources that support caching implement this interface:

```php
interface CacheableInterface
{
    public function setCacheWrapper(CacheWrapper $cacheWrapper): void;
}
```

Currently cached resources: `Country`, `Product`, `Token`.

---

## Cache Key Format

Keys are generated as: `{prefix}{sha1(serialize($key))}`

For token caching, prefix is `dpd_token`. For resource caching, prefix is `dpd`.

Stale/fallback keys append `_prev` to the key.

<!-- AUTO-GENERATED:END -->

<!-- MANUAL:START - Safe to edit, preserved on updates -->
<!-- Add custom notes, team-specific information, or project-specific details below -->
<!-- MANUAL:END -->
