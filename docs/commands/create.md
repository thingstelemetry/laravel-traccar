# Create Command

Create a saved command in Traccar.

## Request

```php
use ThingsTelemetry\Traccar\Dto\CommandData;
use ThingsTelemetry\Traccar\Facades\Command;

$command = Command::create(new CommandData(
    type: 'engineStop',
    deviceId: 6,
    description: 'Engine Stop',
    attributes: ['data' => 'OFF'],
));
```

## Result

Returns `ThingsTelemetry\Traccar\Dto\CommandData`.

## Important Links
- [Traccar Commands](https://www.traccar.org/api-reference/#tag/Commands/paths/~1commands/post)
