# Device Data DTO Reference

The `ThingsTelemetry\Traccar\Dto\DeviceData` represents a Traccar device entity with typed fields and sensible defaults. It is used for both reading devices and constructing payloads (e.g., for creating a device).


```php
use ThingsTelemetry\Traccar\Facades\Device;

$devices = Device::getAll(); // Illuminate\Support\Collection<DeviceData>
$device = $devices->first();
```

Creating a new DTO for create operations

```php
use ThingsTelemetry\Traccar\Dto\DeviceData;
use ThingsTelemetry\Traccar\Dto\DeviceAttributesData;
use ThingsTelemetry\Traccar\Enums\DeviceCategory;
use ThingsTelemetry\Traccar\Enums\DeviceStatus;

$dto = new DeviceData(
    name: 'My Vehicle',
    uniqueId: '8346436046093', // IMEI or serial recommended
    attributes: new DeviceAttributesData(speedLimit: 80),
);
```

## `id` → `integer`|`null`
Traccar device identifier. Null until the device is created by the server.

  ```php
  $device->id; // 2551
  ```

## `name` → `string`
Human-friendly device name.

```php
$device->name; // "Company Truck 12"
```

## `uniqueId` → `string`
Unique device identifier. IMEI, serial number or other id. It has to match the identifier device reports to the server.

```php
$device->uniqueId; // "3567395245678901"
```
  
> [!IMPORTANT]
> The uniqueId must be unique across all devices in the Traccar instance. Traccar uses the uniqueId to match incoming positions with the device they belong to.

## `attributes` → `DeviceAttributesData`
Typed device attribute bag. See the dedicated reference.
  
```php
$attrs = $device->attributes; // instance of DeviceAttributesData
$attrs->toArray(); // array<string, mixed>
  ```

## `status` → `DeviceStatus` (default: UNKNOWN)
Device connection status.

```php
$device->status->value; // "online"
$device->status->label(); // "Online"
```

## `disabled` → `boolean` (default: false)
Whether the device is disabled in Traccar.

```php
$device->disabled; // false
```

## `lastUpdate` → `CarbonImmutable`|`null` (ISO 8601 parsed)
Timestamp of the device’s last update. Parsed to `CarbonImmutable` when present; `null` if missing or unparsable.

```php
$device->lastUpdate?->toIso8601String(); // "2019-08-24T14:15:22Z"
```

## `positionId` → `integer`|`null`
Latest known position record ID for this device.

```php
$device->positionId; // 987654
```

## `groupId` → `integer`|`null`
Group identifier if the device belongs to a Traccar group.

```php
$device->groupId; // 42
```

## `phone` → `string`|`null`
Associated SIM or contact phone number.

```php
$device->phone; // "+1234567890"
```

## `model` → `string`|`null`
Device model or tracker model identifier.

```php
$device->model; // "TK103"
```

## `contact` → `string`|`null`
Optional contact person or label for the device.

```php
$device->contact; // "John Doe"
```

## `category` → `DeviceCategory` (default: DEFAULT)
Device category/classification.

```php
$device->category->value; // "car"
$device->category->label(); // "Car"
```
