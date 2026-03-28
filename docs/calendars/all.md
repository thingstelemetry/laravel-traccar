# Get All Calendars

Fetch calendars from your Traccar server.

## Request

```php
use ThingsTelemetry\Traccar\Facades\Calendar;

$calendars = Calendar::all(all: true, limit: 20);
```

## Result

Returns an `Illuminate\Support\Collection<int, ThingsTelemetry\Traccar\Dto\CalendarData>`.

## Important Links
- [Traccar Calendars](https://www.traccar.org/api-reference/#tag/Calendars/paths/~1calendars/get)
