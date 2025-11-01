# CoordinateFormat Enum Reference

The `ThingsTelemetry\Traccar\Enums\CoordinateFormat` enum defines how Traccar server coordinates are displayed and formatted.

## Example

```php
use ThingsTelemetry\Traccar\Enums\CoordinateFormat;

$format = CoordinateFormat::DMS;
$format->value; // dms
$format->name; // DMS
$format->label(); // Degrees Minutes Seconds (DMS)
```


## Enum Cases

| Case  | Value   | Description                                              |
|-------|---------|----------------------------------------------------------|
| `DD`  | `'dd'`  | Decimal Degrees, e.g., 51.1789, -1.8262                  |
| `DDM` | `'ddm'` | Degrees Decimal Minutes, e.g., 51°10.734′ N, 1°49.572′ W |
| `DMS` | `'dms'` | Degrees Minutes Seconds, e.g., 51°10′44″ N, 1°49′34″ W   |


> [!IMPORTANT]
> The enum values have been derived from the [Traccar source code](https://github.com/traccar/traccar-web/blob/61e5c5d7b14487f898a01e25d890efdf7b260cbc/src/settings/ServerPage.jsx#L108-L116).

## Methods

### `public static function default(): self`

Returns the default coordinate format (`DD`).

### `public function label(): string`

Returns a human-readable label for the format (e.g., `"Decimal Degrees (DD)"`).