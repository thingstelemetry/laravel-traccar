# Summary Report

Fetch summary report rows for one or more devices or groups.

## Request

```php
use Carbon\CarbonImmutable;
use ThingsTelemetry\Traccar\Facades\Report;

$from = CarbonImmutable::parse('2025-11-22T18:30:00Z');
$to = CarbonImmutable::parse('2025-11-23T18:30:00Z');

$report = Report::summary(deviceIds: [6], groupIds: [], from: $from, to: $to, daily: true);
```

## Result

Returns an `Illuminate\Support\Collection<int, ThingsTelemetry\Traccar\Dto\ReportSummaryData>`.

## Important Links
- [Traccar Reports](https://www.traccar.org/api-reference/#tag/Reports/paths/~1reports~1summary/get)
