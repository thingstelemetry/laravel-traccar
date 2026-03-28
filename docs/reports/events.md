# Events Report

Fetch event report rows for one or more devices or groups.

## Request

```php
use Carbon\CarbonImmutable;
use ThingsTelemetry\Traccar\Facades\Report;

$from = CarbonImmutable::parse('2025-11-22T18:30:00Z');
$to = CarbonImmutable::parse('2025-11-23T18:30:00Z');

$report = Report::events(deviceIds: [6], groupIds: [], from: $from, to: $to, types: ['ignitionOn']);
```

## Result

Returns an `Illuminate\Support\Collection<int, ThingsTelemetry\Traccar\Dto\EventData>`.

## Important Links
- [Traccar Reports](https://www.traccar.org/api-reference/#tag/Reports/paths/~1reports~1events/get)
