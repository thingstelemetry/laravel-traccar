# DeviceStatus Enum Reference

The `ThingsTelemetry\Traccar\Enums\DeviceStatus` enum represents a device connection status as reported by Traccar.

## Example

```php
use ThingsTelemetry\Traccar\Enums\DeviceStatus;

$status = DeviceStatus::ONLINE;
$status->value; // online
$status->name; // ONLINE
$status->label(); // Online
```

## Enum Cases

| Case       | Value      | Description |
|------------|------------|-------------|
| `ONLINE`   | `'online'` | Device is connected to the server. This event type is not associated with a position. |
| `UNKNOWN`  | `'unknown'`| Device is connected, but has not reported any data for a period of time. It can also indicate that the device has not closed the connection gracefully. |
| `OFFLINE`  | `'offline'`| Device has disconnected from the server. |

## Methods

### `public static function default(): self`

Returns the default status (`UNKNOWN`).

### `public function label(): string`

Returns a human-readable label for each device status (e.g., `"Online"`).