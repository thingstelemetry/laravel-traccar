# Handling Responses

All API responses are returned as **Data Transfer Objects (DTOs)**. This provides type-safe access to response data with IDE autocompletion support.

## Single Resource Responses

Single resources return a DTO instance:

```php
use ThingsTelemetry\Traccar\Facades\Server;
use ThingsTelemetry\Traccar\Facades\Device;

$serverInfo = Server::get();
// Returns: ThingsTelemetry\Traccar\Dto\ServerData

$device = Device::find(id: 1);
// Returns: ThingsTelemetry\Traccar\Dto\DeviceData
```

## Accessing DTO Properties

Access properties directly on the DTO:

```php
$serverInfo = Server::get();

echo $serverInfo->version;     // '6.10'
echo $serverInfo->id;          // 1
echo $serverInfo->registration; // true/false
```

## Nested DTOs

Some DTOs contain nested DTOs for complex data structures:

```php
$serverInfo = Server::get();

// Nested attributes DTO
echo $serverInfo->attributes->speedUnit->value;  // 'kmh'
echo $serverInfo->attributes->speedUnit->label(); // 'Kilometers per Hour (km/h)'
echo $serverInfo->attributes->timezone;          // 'UTC'

// Nested support class
echo $serverInfo->storageSpace->storage;         // '/var/traccar'
echo $serverInfo->storageSpace->free;            // 5368709120
```

## Collection Responses

Some endpoints return a `Collection` of DTOs:

```php
use Illuminate\Support\Collection;
use ThingsTelemetry\Traccar\Dto\DeviceData;

$devices = Device::all();
// Returns: Collection<int, DeviceData>

foreach ($devices as $device) {
    echo $device->name;      // 'Vehicle A'
    echo $device->uniqueId;  // '1234567890'
    echo $device->status->value; // 'online'
}
```

## Converting to Array

Use `toArray()` method to serialize DTOs back to array format:

```php
$device = Device::find(id: 1);
$array = $device->toArray();

/*
[
    'id' => 1,
    'name' => 'Vehicle A',
    'uniqueId' => '1234567890',
    'status' => 'online',
    'attributes' => [...],
    ...
]
*/
```

## Enum Properties

Some DTO properties are backed enums for type safety:

```php
use ThingsTelemetry\Traccar\Enums\DeviceStatus;
use ThingsTelemetry\Traccar\Enums\Map;

$device = Device::find(id: 1);

// Enum value
echo $device->status->value;    // 'online'

// Enum label (if using backed enum)
echo $serverInfo->map->label(); // 'Open Street Map'

// Compare with enum
if ($device->status === DeviceStatus::ONLINE) {
    // Device is online
}
```
