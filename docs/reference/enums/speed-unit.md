# SpeedUnit Enum Reference

The `ThingsTelemetry\Traccar\Enums\SpeedUnit` enum defines Traccar server speed measurement units.

## Example

```php
use ThingsTelemetry\Traccar\Enums\SpeedUnit;

$unit = SpeedUnit::KILOMETERS_PER_HOUR;
$unit->value; // kmh
$unit->name; // KILOMETERS_PER_HOUR
$unit->label(); // Kilometers per Hour (km/h)
```

## Enum Cases

| Case                  | Value   | Description                 |
|-----------------------|---------|-----------------------------|
| `KNOTS`               | `'kn'`  | Knots (nautical miles/hour) |
| `KILOMETERS_PER_HOUR` | `'kmh'` | Kilometers per Hour         |
| `MILES_PER_HOUR`      | `'mph'` | Miles per Hour              |

> [!IMPORTANT]
> The enum values have been derived from the [Traccar source code](https://github.com/traccar/traccar-web/blob/61e5c5d7b14487f898a01e25d890efdf7b260cbc/src/settings/ServerPage.jsx#L120-L128).

## Methods

### `public static function default(): self`

Returns the default unit (`KNOTS`).

### `public function label(): string`

Returns a human-readable label (e.g., `"Miles per Hour (mph)"`).
