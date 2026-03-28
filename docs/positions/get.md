# Get Positions

Fetch positions from your Traccar server.

Without filters, Traccar returns the latest known positions for the devices the authenticated user can access. You can also filter by time range and device, or fetch one or more specific position IDs.

## Request

```php
use Carbon\CarbonImmutable;
use ThingsTelemetry\Traccar\Facades\Position;

$latestPositions = Position::get();

$from = CarbonImmutable::parse('2025-11-22T18:30:00Z');
$to   = CarbonImmutable::parse('2025-11-23T18:30:00Z');

$history = Position::get(deviceId: 6, from: $from, to: $to);
$selected = Position::get(ids: [12345, 67890]);
```

> [!IMPORTANT]
> If you provide a time filter, both `from` and `to` must be supplied together.
> When `deviceId` is provided, both timestamps are required.

## Results

The response is an `Illuminate\Support\Collection<int, ThingsTelemetry\Traccar\Dto\PositionData>`.

```php
$position = $history->first();

$position->id; // 12345
$position->deviceId; // 6
$position->protocol; // "osmand"
$position->deviceTime->toIso8601String();
$position->latitude; // -1.286389
$position->longitude; // 36.817223
$position->attributes; // array<string, mixed>
```

## Important Links
- [Traccar: Fetch a list of Positions](https://www.traccar.org/api-reference/#tag/Positions/paths/~1positions/get)
- [PositionData DTO reference](./../reference/dto/position-data)
