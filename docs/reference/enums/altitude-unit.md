# AltitudeUnit Enum Reference

The `ThingsTelemetry\Traccar\Enums\AltitudeUnit` enum defines Traccar Server altitude measurement units.

## Example

```php
use ThingsTelemetry\Traccar\Enums\AltitudeUnit;

$unit = AltitudeUnit::FEET;
$unit->value; // 'ft'
$unit->name; // 'FEET'
$unit->label(); // Feet
```

## Enum Cases

| Case     | Value  | Description |
|----------|--------|-------------|
| `METERS` | `'m'`  | Meters      |
| `FEET`   | `'ft'` | Feet        |


> [!IMPORTANT]
> The enum values have been derived from the [Traccar source code](https://github.com/traccar/traccar-web/blob/61e5c5d7b14487f898a01e25d890efdf7b260cbc/src/settings/ServerPage.jsx#L144-L151).


## Methods

### `public static function default(): self`

Returns the default unit (`METERS`).

### `public function label(): string`

Returns a human-readable label (e.g., `"Meters"`).