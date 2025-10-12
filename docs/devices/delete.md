# Delete Device

Delete an existing device from your Traccar server.

> [!WARNING]
> Deleting a device is irreversible. Ensure you target the correct device ID.

## Usage

```php
use TrackTelemetry\Traccar\Dto\StatusData;
use TrackTelemetry\Traccar\Facades\Device;
use TrackTelemetry\Traccar\Enums\Status;

$deviceId = 6;

$result = Device::delete(id: $deviceId); // returns TrackTelemetry\Traccar\Dto\StatusData

if ($result->status === Status::SUCCESS) {
    // Successfully deleted
}
```

## Results

The response is a `TrackTelemetry\Traccar\Dto\StatusData` object containing a `TrackTelemetry\Traccar\Enums\Status`.

```php
$result->status->value; // 'success' or 'failure'
$result->status->name;  // 'SUCCESS' or 'FAILURE'
$result->status->label(); // 'Success' or 'Failure'
```

## Important Links
- Traccar Delete a Device: https://www.traccar.org/api-reference/#tag/Devices/paths/~1devices~1%7Bid%7D/delete
- [Status enum reference](./../reference/enums/status)
