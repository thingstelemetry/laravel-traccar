# Device Share Data Dto Reference

The `ThingsTelemetry\Traccar\Dto\DeviceShareData` represents the result of sharing a device. It includes the generated token, the expiration time, the device ID, and a computed share URL that can be opened in the Traccar web UI.

```php
use Carbon\CarbonImmutable;
use ThingsTelemetry\Traccar\Facades\Share;

$share = Share::device(deviceId: 6, expiration: CarbonImmutable::now()->addHours(12));
```

## Properties

| Property | Type | Description |
|----------|------|-------------|
| `deviceId` | `int` | Identifier of the shared device. |
| `token` | `string` | Share token string returned by the server. |
| `expiration` | `CarbonImmutable` | Token expiration time as a Carbon instance. |
| `url` | `string` | Computed share URL for the Traccar UI. |

## `deviceId` → `integer`

Identifier of the shared device.
```php
$share->deviceId; // 6
```

## `token` → `string`

Share token string returned by the server.
```php
$share->token; // "eyJhbGciOi..."
```

## `expiration` → `CarbonImmutable`

Token expiration time as a Carbon instance.
```php
$share->expiration->toIso8601String(); // "2030-12-31T23:59:59+00:00"
```

## `url` → `string`

Computed share URL for the Traccar UI (base URL derived from config and token appended as query string).
```php
$share->url; // "https://demo.traccar.org/?token=eyJhbGciOi..."
```
