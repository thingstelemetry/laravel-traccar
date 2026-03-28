# Get Sendable Commands

Fetch commands that are currently supported by a device.

## Request

```php
use ThingsTelemetry\Traccar\Facades\Command;

$commands = Command::getSendableForDevice(deviceId: 6);
```

## Result

Returns an `Illuminate\Support\Collection<int, ThingsTelemetry\Traccar\Dto\CommandData>`.

## Important Links
- [Traccar Commands](https://www.traccar.org/api-reference/#tag/Commands/paths/~1commands~1send/get)
