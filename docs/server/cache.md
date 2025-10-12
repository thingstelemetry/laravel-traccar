# Cache

Fetch the server cache state.

> [!IMPORTANT]
> This endpoint is restricted to admin users only on the Traccar server.

## Request

Use the `TrackTelemetry\Traccar\Facades\Server::cache()` method to read the cache string from Traccar.

```php
use TrackTelemetry\Traccar\Facades\Server;

$cache = Server::cache();
```

## Results

The response is a string, for example:

```php
// e.g. "Cache{devices=123, users=45}"
echo $cache;
```