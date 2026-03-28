# Combined Report

Fetch combined report rows (Route, Trips, and Stops) for one or more devices or groups.

## Request

```php
use Carbon\CarbonImmutable;
use ThingsTelemetry\Traccar\Facades\Report;

$from = CarbonImmutable::parse('2025-11-22T18:30:00Z');
$to = CarbonImmutable::parse('2025-11-23T18:30:00Z');

$report = Report::combined(deviceIds: [6], groupIds: [], from: $from, to: $to);
```

## Result

Returns an `Illuminate\Support\Collection<int, ThingsTelemetry\Traccar\Dto\CombinedReportData>`.

The `CombinedReportData` object contains:

| Property | Type | Description |
|----------|------|-------------|
| `deviceId` | `int` | Device identifier |
| `route` | `Collection<PositionData>` | List of positions |
| `events` | `Collection<EventData>` | List of events |

## Important Links
- [Traccar Reports](https://www.traccar.org/api-reference/#tag/Reports/paths/~1reports~1combined/get)
