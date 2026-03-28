# Delete Notification

Delete a notification from Traccar.

## Request

```php
use ThingsTelemetry\Traccar\Facades\Notification;

$result = Notification::delete(id: 41);
```

## Result

Returns `ThingsTelemetry\Traccar\Dto\StatusData`.

## Important Links
- [Traccar Notifications](https://www.traccar.org/api-reference/#tag/Notifications/paths/~1notifications~1%7Bid%7D/delete)
