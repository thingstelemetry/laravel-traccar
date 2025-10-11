# DistanceUnit Enum Reference

The `TrackTelemetry\Traccar\Enums\DistanceUnit` enum defines supported Traccar distance measurement units.

## Enum Cases

| Case             | Value   | Description                |
|------------------|---------|----------------------------|
| `KILOMETERS`     | `'km'`  | Kilometers                 |
| `MILES`          | `'mi'`  | Miles                      |
| `NAUTICAL_MILES` | `'nmi'` | Nautical miles (sea miles) |

## Methods

### `public static function default(): self`

Returns the default unit (`KILOMETERS`).

### `public function label(): string`

Returns a human-readable label (e.g., `"Miles (mi)"`).

## Example

```php
use TrackTelemetry\Traccar\Enums\DistanceUnit;

$unit = DistanceUnit::MILES;
echo $unit->label(); // Miles (mi)

$default = DistanceUnit::default();
echo $default->value; // km
```