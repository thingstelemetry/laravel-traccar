# DeviceCategory Enum Reference

The `TrackTelemetry\Traccar\Enums\DeviceCategory` enum represents the Traccar device category values.

## Example

```php
use TrackTelemetry\Traccar\Enums\DeviceCategory;

$cat = DeviceCategory::TRUCK;
$cat->value; // truck
$cat->name; // TRUCK
$cat->label(); // Truck
```

## Enum Cases

| Case         | Value        |
|--------------|--------------|
| `DEFAULT`    | `'default'`  |
| `ANIMAL`     | `'animal'`   |
| `BICYCLE`    | `'bicycle'`  |
| `BOAT`       | `'boat'`     |
| `BUS`        | `'bus'`      |
| `CAR`        | `'car'`      |
| `CAMPER`     | `'camper'`   |
| `CRANE`      | `'crane'`    |
| `HELICOPTER` | `'helicopter'` |
| `MOTORCYCLE` | `'motorcycle'` |
| `PERSON`     | `'person'`   |
| `PLANE`      | `'plane'`    |
| `SHIP`       | `'ship'`     |
| `TRACTOR`    | `'tractor'`  |
| `TRAILER`    | `'trailer'`  |
| `TRAIN`      | `'train'`    |
| `TRAM`       | `'tram'`     |
| `TRUCK`      | `'truck'`    |
| `VAN`        | `'van'`      |
| `SCOOTER`    | `'scooter'`  |

## Methods

### `public static function default(): self`

Returns the default category (`DEFAULT`).

### `public function label(): string`

Returns a human-readable label for each device category (e.g., `"Truck"`).