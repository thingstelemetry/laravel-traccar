# VolumeUnit Enum Reference

The `TrackTelemetry\Traccar\Enums\VolumeUnit` enum defines Traccar server fuel/volume measurement units.

## Enum Cases

| Case              | Value      | Description     |
|-------------------|------------|-----------------|
| `LITERS`          | `'ltr'`    | Liters          |
| `US_GALLON`       | `'usGal'`  | US Gallon       |
| `IMPERIAL_GALLON` | `'impGal'` | Imperial Gallon |

## Methods

### `public static function default(): self`
Returns the default unit (`LITERS`).

### `public function label(): string`
Returns a human-readable label (e.g., `"US Gallon"`).

## Example

```php
use TrackTelemetry\Traccar\Enums\VolumeUnit;

$unit = VolumeUnit::IMPERIAL_GALLON;
echo $unit->label(); // Imperial Gallon

$default = VolumeUnit::default();
echo $default->value; // ltr
```