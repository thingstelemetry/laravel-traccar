# Get Devices (by user, ids, uniqueIds, or combined)

Fetch devices from your Traccar server by user ID, by device IDs, by unique IDs, or using combined filters.

> [!WARNING]
> - Standard users can only use this operation with their own `userId`. Admins or managers may request devices for any user.
> - Without any params, returns a list of the user's devices

## Usage

### 1) For a given user

```php
use ThingsTelemetry\Traccar\Facades\Device;

$userId = 123;
$devices = Device::get(userId: $userId); // Illuminate\Support\Collection of DeviceData
```

### 2) By device IDs

```php
use ThingsTelemetry\Traccar\Facades\Device;

$devices = Device::get(ids: [6, 7]); // Illuminate\Support\Collection of DeviceData
```

### 3) By uniqueIds

```php
use ThingsTelemetry\Traccar\Facades\Device;

$devices = Device::get(uniqueIds: ['ABC123', 'XYZ789']); // Illuminate\Support\Collection of DeviceData
```

### 4) Combined filters (userId + ids + uniqueIds)

```php
use ThingsTelemetry\Traccar\Facades\Device;

$devices = Device::get(userId: 123, ids: [6], uniqueIds: ['ABC123']); // Illuminate\Support\Collection of DeviceData
```

## Results

The response is a `Illuminate\Support\Collection<int, ThingsTelemetry\Traccar\Dto\DeviceData>`.

```php
$first = $devices->first();

$name = $first->name;                 // \"Truck 1\"
$status = $first->status->label();    // \"Online\"
$category = $first->category->value;  // \"truck\"
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

## Error Handling

```php
use ThingsTelemetry\Traccar\Facades\Device;
use Saloon\Exceptions\Request\RequestException;

try {
    $devices = Device::get(userId: 123);
} catch (RequestException $e) {
    $status = $e->getResponse()->status();
    
    match ($status) {
        400 => // Bad request - invalid parameters,
        401 => // Unauthorized - check API credentials,
        403 => // Forbidden - insufficient permissions to view this user's devices,
        default => // Handle other errors
    };
}
```

## Important Links
- [Traccar Fetch a list of Devices](https://www.traccar.org/api-reference/#tag/Device/paths/~1devices/get)
- [DeviceData DTO reference](./../reference/dto/device-data)
- [DeviceAttributesData DTO reference](./../reference/dto/device-attributes-data)
