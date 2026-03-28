# Create Calendar

Create a calendar in Traccar.

## Request

```php
use ThingsTelemetry\Traccar\Dto\CalendarData;
use ThingsTelemetry\Traccar\Facades\Calendar;

$calendar = Calendar::create(new CalendarData(
    name: 'Working Hours',
    data: 'QkVHSU46VkNBTEVOREFS',
));
```

## Result

Returns `ThingsTelemetry\Traccar\Dto\CalendarData`.

## Important Links
- [Traccar Calendars](https://www.traccar.org/api-reference/#tag/Calendars/paths/~1calendars/post)
