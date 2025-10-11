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

> [!IMPORTANT]
> The enum values have been derived from the [Traccar source code](https://github.com/traccar/traccar-web/blob/61e5c5d7b14487f898a01e25d890efdf7b260cbc/src/settings/ServerPage.jsx#L144-L151).