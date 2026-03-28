# Get All Notifications

Fetch notifications from your Traccar server.

## Request

```php
use ThingsTelemetry\Traccar\Facades\Notification;

$notifications = Notification::getAll(all: true, deviceId: 6);
```

## Result

Returns an `Illuminate\Support\Collection<int, ThingsTelemetry\Traccar\Dto\NotificationData>`.

## Important Links
- [Traccar Notifications](https://www.traccar.org/api-reference/#tag/Notifications/paths/~1notifications/get)
