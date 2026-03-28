# Send Test Notification

Trigger a test notification for the current user.

## Request

### Send to all notificators

```php
use ThingsTelemetry\Traccar\Facades\Notification;

$result = Notification::sendTest();
```

### Send via specific notificator

```php
use ThingsTelemetry\Traccar\Facades\Notification;

$result = Notification::sendTest(notificator: 'mail');
```

## Parameters

| Parameter     | Type     | Description                                         |
|---------------|----------|-----------------------------------------------------|
| `notificator` | `string` | Optional. Specific notificator type to test (e.g., "mail"). |

## Result

Returns `ThingsTelemetry\Traccar\Dto\StatusData`.

## Important Links
- [Traccar Notifications](https://www.traccar.org/api-reference/#tag/Notifications/paths/~1notifications~1test/post)
