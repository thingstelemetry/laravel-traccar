# Position Data DTO Reference

The `ThingsTelemetry\Traccar\Dto\PositionData` represents a single Traccar position fix reported by a device.

```php
use ThingsTelemetry\Traccar\Facades\Position;

$pos = Position::all(ids: [12345])->first(); // PositionData
```

## Properties

| Property | Type | Description |
|----------|------|-------------|
| `id` | `int` | Unique position identifier. |
| `deviceId` | `int` | The device that produced this position. |
| `protocol` | `string` | Connector/protocol name. |
| `deviceTime` | `CarbonImmutable` | Timestamp when the device recorded the position. |
| `fixTime` | `CarbonImmutable` | Timestamp of the GPS fix. |
| `serverTime` | `CarbonImmutable` | Timestamp when the server stored the position. |
| `valid` | `bool` | Whether the position is considered valid. |
| `latitude` | `float` | Latitude in decimal degrees. |
| `longitude` | `float` | Longitude in decimal degrees. |
| `altitude` | `float` | Altitude in meters. |
| `speed` | `float` | Speed in knots. |
| `course` | `float` | Heading/course in degrees. |
| `address` | `string` | Resolved human-readable address. |
| `accuracy` | `float` | Estimated accuracy. |
| `network` | `array<string, mixed>` | Raw network-related information. |
| `geofenceIds` | `array<int, int>` | IDs of geofences related to this position. |
| `attributes` | `array<string, mixed>` | Additional attributes returned by Traccar. |

## `id` → `integer`
Unique position identifier in Traccar.

```php
$pos->id; // 12345
```

## `deviceId` → `integer`
The device that produced this position.

```php
$pos->deviceId; // 42
```

## `protocol` → `string`
Connector/protocol name that produced the position (e.g., `osmand`, `teltonika`).

```php
$pos->protocol; // "osmand"
```

## `deviceTime` → `CarbonImmutable`
Timestamp when the device recorded the position (ISO 8601).

```php
$pos->deviceTime->toIso8601String(); // "2019-08-24T14:15:22Z"
```

## `fixTime` → `CarbonImmutable`
Timestamp of the GPS fix (ISO 8601).

```php
$pos->fixTime->toIso8601String(); // "2019-08-24T14:15:22Z"
```

## `serverTime` → `CarbonImmutable`
Timestamp when the server stored the position (ISO 8601).

```php
$pos->serverTime->toIso8601String(); // "2019-08-24T14:15:23Z"
```

## `valid` → `boolean`
Indicates whether the position is considered valid by Traccar.

```php
$pos->valid; // true
```

## `latitude` → `float`
Latitude in decimal degrees.

```php
$pos->latitude; // -1.286389
```

## `longitude` → `float`
Longitude in decimal degrees.

```php
$pos->longitude; // 36.817223
```

## `altitude` → `float`
Altitude in meters.

```php
$pos->altitude; // 1679.3
```

## `speed` → `float`
Speed in knots as reported by Traccar.

```php
$pos->speed; // 12.5 // knots
```

## `course` → `float`
Heading/course in degrees (0–360).

```php
$pos->course; // 275.0
```

## `address` → `string`
Resolved human-readable address, if reverse geocoding is enabled. Can be an empty string.

```php
$pos->address; // "1600 Amphitheatre Pkwy, Mountain View, CA" or ""
```

## `accuracy` → `float`
Estimated accuracy (unit as provided by Traccar, typically meters).

```php
$pos->accuracy; // 5.0
```

## `network` → `array<string, mixed>`
Raw network-related information associated with the position.

```php
$pos->network; // [ 'cellTowers' => [...], 'wifiAccessPoints' => [...] ]
```

## `geofenceIds` → `array<int, int>`
IDs of geofences related to this position. Can be an empty array.

```php
$pos->geofenceIds; // [3, 5] or []
```

## `attributes` → `array<string, mixed>`
Additional attributes returned by Traccar for the position. May include vendor/device-specific keys. Can be empty.

```php
$pos->attributes; // [ 'sat' => 12, 'battery' => 88, 'ignition' => true, ... ]
```

---

### Notes
- All fields are required on the DTO. When constructing via `PositionData::fromArray(...)`, empty/invalid time strings are parsed safely and default to `now()`.
- `address` may be an empty string if reverse geocoding is disabled or not available.
- `geofenceIds` may be an empty array if no geofences are associated.
- `attributes` and `network` default to empty arrays when missing.
