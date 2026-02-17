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

## Error Handling

```php
use ThingsTelemetry\Traccar\Facades\Server;
use Saloon\Exceptions\Request\RequestException;

try {
    $cache = Server::cache();
} catch (RequestException $e) {
    $status = $e->getResponse()->status();
    
    match ($status) {
        401 => // Unauthorized - check API credentials,
        403 => // Forbidden - requires admin privileges,
        default => // Handle other errors
    };
}
```