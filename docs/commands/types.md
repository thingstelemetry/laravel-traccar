# Get Command Types

Fetch available command types from Traccar.

## Request

```php
use ThingsTelemetry\Traccar\Facades\Command;

$types = Command::types(deviceId: 6, textChannel: false);
```

## Result

Returns an `Illuminate\Support\Collection<int, ThingsTelemetry\Traccar\Dto\CommandTypeData>`.

## Important Links
- [Traccar Commands](https://www.traccar.org/api-reference/#tag/Commands/paths/~1commands~1types/get)
