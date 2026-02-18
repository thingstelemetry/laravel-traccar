# Cache

Fetch the server cache state.

> [!IMPORTANT]
> This endpoint is restricted to admin users only on the Traccar server.

## Request

Use the `ThingsTelemetry\Traccar\Facades\Server::cache()` method to read the cache string from Traccar.

```php

$cache = \ThingsTelemetry\Traccar\Facades\Server::cache();
```

## Results

The response is a string, for example:

```php
// e.g. "Cache{devices=123, users=45}"
echo $cache;
```

## Important Links
- [Traccar API: Cache](https://www.traccar.org/api-reference/#tag/Server/paths/~1server/cache/get)