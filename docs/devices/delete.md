# Delete Device

Delete an existing device from your Traccar server.

> [!WARNING]
> Deleting a device is irreversible. Ensure you target the correct device ID.

## Usage

```php
use ThingsTelemetry\Traccar\Dto\StatusData;
use ThingsTelemetry\Traccar\Facades\Device;
use ThingsTelemetry\Traccar\Enums\Status;

$deviceId = 6;

$result = Device::delete(id: $deviceId); // returns ThingsTelemetry\Traccar\Dto\StatusData

if ($result->status === Status::SUCCESS) {
    // Successfully deleted
}
```

## Results

The response is a `ThingsTelemetry\Traccar\Dto\StatusData` object containing a `ThingsTelemetry\Traccar\Enums\Status`.

```php
$result->status->value; // 'success' or 'failure'
$result->status->name;  // 'SUCCESS' or 'FAILURE'
$result->status->label(); // 'Success' or 'Failure'
```

## Error Handling

```php
use ThingsTelemetry\Traccar\Facades\Device;
use Saloon\Exceptions\Request\RequestException;

try {
    $result = Device::delete(id: 6);
} catch (RequestException $e) {
    $status = $e->getResponse()->status();
    
    match ($status) {
        401 => // Unauthorized - check API credentials,
        403 => // Forbidden - insufficient permissions,
        404 => // Device not found - check device ID,
        default => // Handle other errors
    };
}
```

## Important Links
- Traccar Delete a Device: https://www.traccar.org/api-reference/#tag/Devices/paths/~1devices~1%7Bid%7D/delete
- [Status enum reference](./../reference/enums/status)
