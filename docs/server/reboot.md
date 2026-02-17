# Reboot Server

Trigger a reboot of your Traccar server instance.

> [!IMPORTANT] PROCEED WITH CAUTION.
> - This endpoint is restricted to admin users only.
> - During the reboot, new device positions may not be recorded in the data.

## Request

Use the `ThingsTelemetry\Traccar\Facades\Server::reboot()` method to reboot the server.

```php
use ThingsTelemetry\Traccar\Facades\Server;

$result = Server::reboot();
```

## Results

The response is an instance of `ThingsTelemetry\Traccar\Dto\StatusData`.

```php
$status = $result->status->value; // "success"
```

## Error Handling

```php
use ThingsTelemetry\Traccar\Facades\Server;
use Saloon\Exceptions\Request\RequestException;

try {
    $result = Server::reboot();
} catch (RequestException $e) {
    $status = $e->getResponse()->status();
    
    match ($status) {
        401 => // Unauthorized - check API credentials,
        403 => // Forbidden - requires admin privileges,
        default => // Handle other errors
    };
}
```