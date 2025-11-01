# Get Devices

Fetch the list of devices from your Traccar server.

> [!WARNING]
> This operation can only be used by admins or managers to fetch all entities.

## Request

Use the `ThingsTelemetry\Traccar\Facades\Device::getAll()` method to retrieve all devices.

```php
use ThingsTelemetry\Traccar\Facades\Device;

$devices = Device::getAll(); // Illuminate\Support\Collection of DeviceData
```

## Results

The response is a `Illuminate\Support\Collection<int, ThingsTelemetry\Traccar\Dto\DeviceData>`.

```php
$first = $devices->first();

$name = $first->name;                 // "Truck 1"
$status = $first->status->label();    // "Online"
$category = $first->category->value;  // "truck"
$lastSeen = $first->lastUpdate?->toIso8601String();

// Attributes (typed)
$speedLimit = $first->attributes->speedLimit; // 80.0 (knots)
```

### Key Result Items

- `status` → [`DeviceStatus`](./../reference/enums/device-status)
  Enum representing device connection state.
- `category` → [`DeviceCategory`](./../reference/enums/device-category)
  Enum representing device category/type.
- `attributes` → [`DeviceAttributesData`](./../reference/dto/device-attributes-data)
  Typed DTO for device attributes.

## Important Links
- [Traccar Fetch a list of Devices](https://www.traccar.org/api-reference/#tag/Device/paths/~1devices/get)
- [DeviceData DTO reference](./../reference/dto/device-data)
- [DeviceAttributesData DTO reference](./../reference/dto/device-attributes-data)