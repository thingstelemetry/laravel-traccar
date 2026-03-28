# Send Command

Send a command to a device or group.

## Request

```php
use ThingsTelemetry\Traccar\Dto\CommandData;
use ThingsTelemetry\Traccar\Facades\Command;

$result = Command::send(
    data: new CommandData(
        type: 'engineStop',
        deviceId: 6,
        attributes: ['data' => 'OFF'],
    ),
    groupId: null,
);
```

## Result

Returns `ThingsTelemetry\Traccar\Dto\CommandDispatchResultData`.

```php
$result->sentCommand; // CommandData|null
$result->queuedCommands; // Collection<int, QueuedCommandData>
```

## Important Links
- [Traccar Commands](https://www.traccar.org/api-reference/#tag/Commands/paths/~1commands~1send/post)
