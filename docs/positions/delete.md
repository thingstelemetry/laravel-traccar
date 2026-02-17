# Delete Position

Delete an existing position from your Traccar server.

> [!WARNING]
> Deleting a position is irreversible and can compromise data integrity. Ensure you target the correct position ID.

## Usage

```php
use ThingsTelemetry\Traccar\Dto\StatusData;
use ThingsTelemetry\Traccar\Facades\Position;
use ThingsTelemetry\Traccar\Enums\Status;

$positionId = 12345;

$result = Position::delete(id: $positionId); // returns ThingsTelemetry\Traccar\Dto\StatusData

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
use ThingsTelemetry\Traccar\Facades\Position;
use Saloon\Exceptions\Request\RequestException;

try {
    $result = Position::delete(id: 12345);
} catch (RequestException $e) {
    $status = $e->getResponse()->status();
    
    match ($status) {
        401 => // Unauthorized - check API credentials,
        403 => // Forbidden - insufficient permissions,
        404 => // Position not found - check position ID,
        default => // Handle other errors
    };
}
```

## Important Links
- [Traccar Delete a Position](https://www.traccar.org/api-reference/#tag/Positions/paths/~1positions~1%7Bid%7D/delete)
- [Status enum reference](./../reference/enums/status)
