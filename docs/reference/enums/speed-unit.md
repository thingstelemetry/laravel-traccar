# SpeedUnit Enum Reference

The `TrackTelemetry\Traccar\Enums\SpeedUnit` enum defines Traccar server speed measurement units.

## Enum Cases

| Case                  | Value   | Description                 |
|-----------------------|---------|-----------------------------|
| `KNOTS`               | `'kn'`  | Knots (nautical miles/hour) |
| `KILOMETERS_PER_HOUR` | `'kmh'` | Kilometers per Hour         |
| `MILES_PER_HOUR`      | `'mph'` | Miles per Hour              |

## Methods

### `public static function default(): self`

Returns the default unit (`KNOTS`).

### `public function label(): string`

Returns a human-readable label (e.g., `"Miles per Hour (mph)"`).

## Example

```php
use TrackTelemetry\Traccar\Enums\SpeedUnit;

$unit = SpeedUnit::KILOMETERS_PER_HOUR;
echo $unit->label(); // Kilometers per Hour (km/h)

$default = SpeedUnit::default();
echo $default->value; // kn
```

> [!IMPORTANT]
> The enum values have been derived from the [Traccar source code](https://github.com/traccar/traccar-web/blob/61e5c5d7b14487f898a01e25d890efdf7b260cbc/src/settings/ServerPage.jsx#L120-L128).