# Export Positions as CSV

Export device positions in a time range as CSV.

## Request

```php
use Carbon\CarbonImmutable;
use ThingsTelemetry\Traccar\Facades\Position;

$from = Carbon\CarbonImmutable::parse('2025-11-22T18:30:00Z');
$to   = Carbon\CarbonImmutable::parse('2025-11-23T18:30:00Z');

$csv = Position::exportCsv(deviceId: 6, from: $from, to: $to, geofenceId: 10);
```

## Results

The response is a raw CSV string.

```php
$lines = explode("\n", $csv);
```

## Important Links
- [Traccar: Export Positions as CSV](https://www.traccar.org/api-reference/#tag/Positions/paths/~1positions~1csv/get)
