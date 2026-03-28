# Find Device

Fetch a specific device by ID from your Traccar server.

> [!WARNING]
> - Standard users can only access devices they own or have been shared with them
> - Admins and managers can access any device

## Usage

Use the `ThingsTelemetry\Traccar\Facades\Device::find(int $id)` method to retrieve a single device.

```php
use ThingsTelemetry\Traccar\Facades\Device;

$device = Device::find(6); // ThingsTelemetry\Traccar\Dto\DeviceData
```

## Result

The response is an instance of `ThingsTelemetry\Traccar\Dto\DeviceData`.

```php
$device->id; // 6
$device->name; // "Truck 1"
$device->uniqueId; // "ABC123"
$device->status->value; // "online"
$device->status->label(); // "Online"
$device->category->value; // "truck"
$device->disabled; // false
$device->lastUpdate?->toIso8601String(); // "2019-08-24T14:15:22+00:00"
$device->positionId; // 123
$device->groupId; // 1
$device->phone; // "+123456789"
$device->model; // "TK103"
$device->contact; // "Ops"

// Attributes (typed)
$device->attributes->speedLimit; // 80.0 (knots)
$device->attributes->fuelDropThreshold; // 5.0
$device->attributes->fuelIncreaseThreshold; // 10.0
```

### Key Result Items

- `status` → [`DeviceStatus`](./../reference/enums/device-status)
  Enum representing device connection state (online, offline, unknown).
- `category` → [`DeviceCategory`](./../reference/enums/device-category)
  Enum representing device category/type (car, truck, motorcycle, etc.).
- `attributes` → [`DeviceAttributesData`](./../reference/dto/device-attributes-data)
  Typed DTO for device-specific attributes like speed limit, fuel thresholds, etc.
- `lastUpdate` → `?CarbonImmutable`
  When the device last sent a position update (null if never).

## Related Operations

- [Get All Devices](./all) - Fetch all accessible devices
- [All Devices With Filters](./all-filters) - Fetch devices with filters
- [Create Device](./create) - Create a new device
- [Update Device](./update) - Update an existing device
- [Delete Device](./delete) - Remove a device

## Important Links

- [Traccar API: Get Device by ID](https://www.traccar.org/api-reference/#tag/Device/paths/~1devices~1%7Bid%7D/get)
- [DeviceData DTO reference](./../reference/dto/device-data)
- [DeviceAttributesData DTO reference](./../reference/dto/device-attributes-data)
