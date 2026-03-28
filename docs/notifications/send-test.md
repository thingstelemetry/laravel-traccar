# Send Test Notification

Trigger a test notification for the current user.

## Request

```php
use ThingsTelemetry\Traccar\Facades\Notification;

$result = Notification::sendTest();
```

## Result

Returns `ThingsTelemetry\Traccar\Dto\StatusData`.

## Important Links
- [Traccar Notifications](https://www.traccar.org/api-reference/#tag/Notifications/paths/~1notifications~1test/post)
