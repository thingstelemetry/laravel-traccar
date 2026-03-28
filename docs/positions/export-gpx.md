# Export Positions as GPX

Export device positions in a time range as a GPX document.

## Request

```php
use Carbon\CarbonImmutable;
use ThingsTelemetry\Traccar\Facades\Position;

$from = CarbonImmutable::parse('2025-11-22T18:30:00Z');
$to   = CarbonImmutable::parse('2025-11-23T18:30:00Z');

$gpx = Position::exportGpx(deviceId: 6, from: $from, to: $to);
```

## Results

The response is a raw GPX string.

```php
str_contains($gpx, '<gpx'); // true
```

## Important Links
- [Traccar: Export Positions as GPX](https://www.traccar.org/api-reference/#tag/Positions/paths/~1positions~1gpx/get)
