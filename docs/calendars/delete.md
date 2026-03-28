# Delete Calendar

Delete a calendar from Traccar.

## Request

```php
use ThingsTelemetry\Traccar\Facades\Calendar;

$result = Calendar::delete(id: 7);
```

## Result

Returns `ThingsTelemetry\Traccar\Dto\StatusData`.

## Important Links
- [Traccar Calendars](https://www.traccar.org/api-reference/#tag/Calendars/paths/~1calendars~1%7Bid%7D/delete)
