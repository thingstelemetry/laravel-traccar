# Export Positions as KML

Export device positions in a time range as a KML document.

## Request

```php
use Carbon\CarbonImmutable;
use ThingsTelemetry\Traccar\Facades\Position;

$from = CarbonImmutable::parse('2025-11-22T18:30:00Z');
$to   = CarbonImmutable::parse('2025-11-23T18:30:00Z');

$kml = Position::exportKml(deviceId: 6, from: $from, to: $to);
```

## Results

The response is a raw KML string.

```php
str_starts_with($kml, '<?xml'); // true
```

## Important Links
- [Traccar: Export Positions as KML](https://www.traccar.org/api-reference/#tag/Positions/paths/~1positions~1kml/get)
