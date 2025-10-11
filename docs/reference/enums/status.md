# Status Enum Reference

The `TrackTelemetry\Traccar\Enums\Status` enum represents a boolean-like operation result for actions such as deleting a device.

## Example

```php
use TrackTelemetry\Traccar\Enums\Status;

$status = Status::SUCCESS;
$status->value; // 'success'
$status->name; // 'SUCCESS'
$status->label(); // 'Success'
```

## Enum Cases

| Case      | Value      | Description                         |
|-----------|------------|-------------------------------------|
| `SUCCESS` | `'success'`| Operation completed successfully.   |
| `FAILURE` | `'failure'`| Operation failed.                   |

## Methods

### `public static function default(): self`

Returns the default status (`FAILURE`).

### `public function label(): string`

Returns a human-readable label for the status (e.g., `"Success"`).
