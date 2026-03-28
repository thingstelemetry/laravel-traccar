# Delete Command

Delete a saved command from Traccar.

## Request

```php
use ThingsTelemetry\Traccar\Facades\Command;

$result = Command::delete(id: 21);
```

## Result

Returns `ThingsTelemetry\Traccar\Dto\StatusData`.

## Important Links
- [Traccar Commands](https://www.traccar.org/api-reference/#tag/Commands/paths/~1commands~1%7Bid%7D/delete)
