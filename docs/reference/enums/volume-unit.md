# VolumeUnit Enum Reference

The `ThingsTelemetry\Traccar\Enums\VolumeUnit` enum defines Traccar server fuel/volume measurement units.


## Example

```php
use ThingsTelemetry\Traccar\Enums\VolumeUnit;

$unit = VolumeUnit::IMPERIAL_GALLON;
$unit->value; // impGal
$unit->name; // IMPERIAL_GALLON
$unit->label(); // Imperial Gallon
```

## Enum Cases

| Case              | Value      | Description     |
|-------------------|------------|-----------------|
| `LITERS`          | `'ltr'`    | Liters          |
| `US_GALLON`       | `'usGal'`  | US Gallon       |
| `IMPERIAL_GALLON` | `'impGal'` | Imperial Gallon |

> [!IMPORTANT]
> The enum values have been derived from the [Traccar source code](https://github.com/traccar/traccar-web/blob/61e5c5d7b14487f898a01e25d890efdf7b260cbc/src/settings/ServerPage.jsx#L155-L163).

## Methods

### `public static function default(): self`
Returns the default unit (`LITERS`).

### `public function label(): string`
Returns a human-readable label (e.g., `"US Gallon"`).