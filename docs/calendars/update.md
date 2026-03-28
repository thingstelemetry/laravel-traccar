# Update Calendar

Update an existing Traccar calendar.

## Request

```php
use ThingsTelemetry\Traccar\Dto\CalendarData;
use ThingsTelemetry\Traccar\Facades\Calendar;

$calendar = Calendar::update(new CalendarData(
    id: 7,
    name: 'Working Hours',
    data: 'QkVHSU46VkNBTEVOREFS',
));
```

## Result

Returns `ThingsTelemetry\Traccar\Dto\CalendarData`.

## Important Links
- [Traccar Calendars](https://www.traccar.org/api-reference/#tag/Calendars/paths/~1calendars~1%7Bid%7D/put)
