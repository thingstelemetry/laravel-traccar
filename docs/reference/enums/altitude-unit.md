# AltitudeUnit Enum Reference

The `TrackTelemetry\Traccar\Enums\AltitudeUnit` enum defines Traccar Server altitude measurement units.

## Enum Cases

| Case     | Value  | Description |
|----------|--------|-------------|
| `METERS` | `'m'`  | Meters      |
| `FEET`   | `'ft'` | Feet        |

## Methods

### `public static function default(): self`

Returns the default unit (`METERS`).

### `public function label(): string`

Returns a human-readable label (e.g., `"Meters"`).

## Example

```php
use TrackTelemetry\Traccar\Enums\AltitudeUnit;

$unit = AltitudeUnit::FEET;
echo $unit->label(); // Feet

$default = AltitudeUnit::default();
echo $default->value; // m
```