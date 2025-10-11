# Get Devices for a User

Fetch the list of devices assigned to a specific user from your Traccar server.

> [!WARNING]
> Without any params, returns a list of the user's devices
> Standard users can use this only with their own userId

## Request

Use the `TrackTelemetry\Traccar\Facades\Device::getForUser($userId)` method to retrieve a user's devices.

```php
use TrackTelemetry\Traccar\Facades\Device;

$devices = Device::getForUser(userId: 2, id: [1,2], uniqueId: ['1234567890', '0987654321']); // Illuminate\Support\Collection of DeviceData
```

## Results

The response is a `Illuminate\Support\Collection<int, TrackTelemetry\Traccar\Dto\DeviceData>`.

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

## Permissions
- Standard users: Only allowed to call this with their own `userId`.
- Admins/Managers: May fetch devices for any `userId`.

## Important Links
- [Traccar Fetch a list of Devices](https://www.traccar.org/api-reference/#tag/Device/paths/~1devices/get)
- [DeviceData DTO reference](./../reference/dto/device-data)
- [DeviceAttributesData DTO reference](./../reference/dto/device-attributes-data)
