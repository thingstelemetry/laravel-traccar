# Create Notification

Create a notification in Traccar.

## Request

```php
use ThingsTelemetry\Traccar\Dto\NotificationData;
use ThingsTelemetry\Traccar\Facades\Notification;

$notification = Notification::create(new NotificationData(
    type: 'ignitionOn',
    notificators: 'web,mail',
));
```

## Result

Returns `ThingsTelemetry\Traccar\Dto\NotificationData`.

## Important Links
- [Traccar Notifications](https://www.traccar.org/api-reference/#tag/Notifications/paths/~1notifications/post)
