# Device Data Dto Reference

The `TrackTelemetry\Traccar\Dto\DeviceData` represents a Traccar device entity. It provides typed access to device metadata and timestamps. 

```php
use TrackTelemetry\Traccar\Facades\Device;

$devices = Device::getAll(); // Illuminate\Support\Collection of DeviceData
$device = $devices->first();
```

## `id` → `integer`

Traccar device identifier.
```php
$device->id; // 2551
```

## `name` → `string`

Human-friendly device name.
```php
$device->name; // "Company Truck 12"
```

## `uniqueId` → `string`

Unique device identifier (e.g., IMEI or tracker ID).
```php
$device->uniqueId; // "356612345678901"
```

## `status` → [`DeviceStatus`](../enums/device-status)

Device connection status.
```php
$device->status->value; // "online"
$device->status->label(); // "Online"
```

## `disabled` → `boolean`

Whether the device is disabled in Traccar.
```php
$device->disabled; // false
```

## `lastUpdate` → `string|null` (ISO 8601) cast to `CarbonImmutable|null`

Timestamp of the device’s last update. Parsed to `CarbonImmutable` when present; `null` if missing.
```php
$device->lastUpdate?->toIso8601String(); // "2019-08-24T14:15:22Z"
```

## `positionId` → `integer|null`

Latest known position record ID for this device.
```php
$device->positionId; // 987654
```

## `groupId` → `integer|null`

Group identifier if the device belongs to a Traccar group.
```php
$device->groupId; // 42
```

## `phone` → `string|null`

Associated SIM or contact phone number.
```php
$device->phone; // "+1234567890"
```

## `model` → `string|null`

Device model or tracker model identifier.
```php
$device->model; // "TK103"
```

## `contact` → `string|null`

Optional contact person or label for the device.
```php
$device->contact; // "John Doe"
```

## `category` → [`DeviceCategory`](../enums/device-category)

Device category/classification.
```php
$device->category->value; // "car"
$device->category->label(); // "Car"
```

## `attributes` → [`DeviceAttributesData`](./device-attributes-data)

Typed device-specific attributes. Instance of `TrackTelemetry\\Traccar\\Dto\\DeviceAttributesData`.
```php
$attrs = $device->attributes; // instance of DeviceAttributesData
$attrs->toArray(); // array<string, mixed>
```
