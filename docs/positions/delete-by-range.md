# Delete Device Positions in a Time Range

Delete all stored positions for a specific device within a given time span.

> [!WARNING]
> Deleting positions is irreversible and can compromise reporting accuracy. Ensure you target the correct device and time range.

## Usage

```php
use Carbon\CarbonImmutable;
use ThingsTelemetry\Traccar\Dto\StatusData;
use ThingsTelemetry\Traccar\Enums\Status;
use ThingsTelemetry\Traccar\Facades\Position;

$deviceId = 6;

$from = CarbonImmutable::parse('2025-11-22T18:30:00Z');
$to   = CarbonImmutable::parse('2025-12-23T18:30:00Z');

// returns ThingsTelemetry\Traccar\Dto\StatusData
$result = Position::deleteForDeviceInRange(deviceId: $deviceId, from: $from, to: $to); 

if ($result->status === Status::SUCCESS) {
    // Successfully deleted positions in the given range
}
```

> [!IMPORTANT]
> The `from` timestamp must be strictly **before** the `to` timestamp, otherwise a
> `Illuminate\Validation\ValidationException` will be thrown.

## Results

The response is a `ThingsTelemetry\Traccar\Dto\StatusData` object containing a `ThingsTelemetry\Traccar\Enums\Status`.

```php
$result->status->value; // 'success' or 'failure'
$result->status->name;  // 'SUCCESS' or 'FAILURE'
$result->status->label(); // 'Success' or 'Failure'
```

## Error Handling

```php
use ThingsTelemetry\Traccar\Facades\Position;
use Illuminate\Validation\ValidationException;
use Saloon\Exceptions\Request\RequestException;

try {
    $result = Position::deleteForDeviceInRange(deviceId: 6, from: $from, to: $to);
} catch (ValidationException $e) {
    // Handle validation errors (from timestamp must be before to)
    $errors = $e->errors();
} catch (RequestException $e) {
    $status = $e->getResponse()->status();
    
    match ($status) {
        400 => // Bad request - invalid device or date range,
        401 => // Unauthorized - check API credentials,
        403 => // Forbidden - insufficient permissions,
        404 => // Device not found - check device ID,
        default => // Handle other errors
    };
}
```

## Important Links
- [Traccar: Delete positions for a device and time range](https://www.traccar.org/api-reference/#tag/Positions/paths/~1positions/delete)
- [Status enum reference](./../reference/enums/status)
