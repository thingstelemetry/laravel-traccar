# Send Notification

Send a custom notification using a specific notificator.

## Request

```php
use ThingsTelemetry\Traccar\Dto\NotificationMessageData;
use ThingsTelemetry\Traccar\Facades\Notification;

$result = Notification::send(
    notificator: 'mail',
    message: new NotificationMessageData(
        body: 'Hello team',
        subject: 'Alert',
    ),
    userIds: [1, 2],
);
```

## Parameters

| Parameter     | Type                      | Description                                                                 |
|---------------|---------------------------|-----------------------------------------------------------------------------|
| `notificator` | `string`                  | Required. Notificator type (e.g., "mail", "telegram").                       |
| `message`     | `NotificationMessageData` | Required. The message to send.                                              |
| `userIds`     | `array<int>`              | Optional. List of user IDs. If omitted, sends to all users permitted for current user. |

## Result

Returns `ThingsTelemetry\Traccar\Dto\StatusData`.

## Important Links
- [Traccar Notifications](https://www.traccar.org/api-reference/#tag/Notifications/paths/~1notifications~1send~1%7Bnotificator%7D/post)
