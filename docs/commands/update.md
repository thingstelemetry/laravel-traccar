# Update Command

Update a saved command in Traccar.

## Request

```php
use ThingsTelemetry\Traccar\Dto\CommandData;
use ThingsTelemetry\Traccar\Facades\Command;

$command = Command::update(new CommandData(
    id: 21,
    type: 'engineStop',
    deviceId: 6,
    description: 'Engine Stop',
    attributes: ['data' => 'OFF'],
));
```

## Result

Returns `ThingsTelemetry\Traccar\Dto\CommandData`.

## Important Links
- [Traccar Commands](https://www.traccar.org/api-reference/#tag/Commands/paths/~1commands~1%7Bid%7D/put)
