# Reboot Server

Trigger a reboot of your Traccar server instance.

> [!IMPORTANT] PROCEED WITH CAUTION.
> - This endpoint is restricted to admin users only.
> - During the reboot, new device positions may not be recorded in the data.

## Request

Use the `TrackTelemetry\Traccar\Facades\Server::reboot()` method to reboot the server.

```php
use TrackTelemetry\Traccar\Facades\Server;

$result = Server::reboot();
```

## Results

The response is an instance of `TrackTelemetry\Traccar\Dto\StatusData`.

```php
$status = $result->status->value; // "success"
```