# Garbage Collector

Trigger the JVM garbage collector on the Traccar server.

> [!IMPORTANT]
> This endpoint is restricted to admin users only on the Traccar server.

## Request

Use the `ThingsTelemetry\Traccar\Facades\Server::gc()` method to execute GC.

```php
use ThingsTelemetry\Traccar\Facades\Server;

$result = Server::gc();
```

## Results

The response is an instance of `ThingsTelemetry\Traccar\Dto\StatusData`.

```php
$status = $result->status->value; // "success"
```

> Note: Traccar may return an empty response body. This package treats a successful HTTP call as `success`.
