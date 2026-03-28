# Get Notification Types

Fetch available notification types from Traccar.

## Request

```php
use ThingsTelemetry\Traccar\Facades\Notification;

$types = Notification::types();
```

## Result

Returns an `Illuminate\Support\Collection<int, ThingsTelemetry\Traccar\Dto\NotificationTypeData>`.

## Important Links
- [Traccar Notifications](https://www.traccar.org/api-reference/#tag/Notifications/paths/~1notifications~1types/get)
