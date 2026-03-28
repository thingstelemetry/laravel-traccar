# Get All Commands

Fetch saved commands from your Traccar server.

## Request

```php
use ThingsTelemetry\Traccar\Facades\Command;

$commands = Command::all(all: true, deviceId: 6);
```

## Result

Returns an `Illuminate\Support\Collection<int, ThingsTelemetry\Traccar\Dto\CommandData>`.

## Important Links
- [Traccar Commands](https://www.traccar.org/api-reference/#tag/Commands/paths/~1commands/get)
