# Create Device

Create a device on your Traccar server.

> [!IMPORTANT]
> - uniqueId must be unique, use device IMEI. If not available, it means another device is registered
> - Avoid setting `positionId` and `groupId` unless you the exact values.
> - `id` attributes is ignored if set. Traccar will generate a new ID.

## Usage

```php
use TrackTelemetry\Traccar\Enums\DeviceCategory;
use TrackTelemetry\Traccar\Enums\DeviceStatus;
use TrackTelemetry\Traccar\Dto\DeviceData;
use TrackTelemetry\Traccar\Dto\DeviceAttributesData;
use TrackTelemetry\Traccar\Facades\Device;

$attributes = new DeviceAttributesData(
    speedLimit: 80,
    fuelDropThreshold: 5.0,
    fuelIncreaseThreshold: 10,
    reportIgnoreOdometer: false,
    devicePassword: '34235',
);

$deviceData = new DeviceData(
    name: 'My Vehicle',
    uniqueId: '8346436046093', 
    status: DeviceStatus::UNKNOWN, // ignored on create
    disabled: false,
    phone: '+254722000000',
    model: 'Teltonika FMB920',
    contact: 'Track Telemetry Developer',
    category: DeviceCategory::CAR,
    attributes: $attributes,
);

$device = Device::create($deviceData); // returns TrackTelemetry\Traccar\Dto\DeviceData
```

## Results

The response is a `TrackTelemetry\Traccar\Dto\DeviceData>`.

```php
$first = $devices->first();

$name = $device->name;                 // "Truck 1"
$status = $device->status->label();    // "Online"
$category = $device->category->value;  // "truck"
$lastSeen = $device->lastUpdate?->toIso8601String();

$speedLimit = $device->attributes->speedLimit; // 80.0 (knots)
```

## Errors

### 400 - Key (uniqueid)=(xxxx) already exists.

```shell
Bad Request (400) Response: org.traccar.storage.StorageException: org.postgresql.util.PSQLException: ERROR: duplicate key value violates unique constraint "tc_devices_uniqueid_key" Detail: Key (uniqueid)=(AX3WX9XT6ZYMPQWJ) already exists
```
This means a device with the given `uniqueid` already exists in the server. Get the device details instead or use a different `uniqueid`.

### 400 - Key (groupid)=(2000) is not present in table "tc_groups".

```shell
Bad RequestBad Request (400) Response: org.traccar.storage.StorageException: org.postgresql.util.PSQLException: ERROR: insert or update on table "tc_devices" violates foreign key constraint "fk_devices_groupid" Detail: Key (groupid)=(2000) is not present in table "tc_groups".
```
This means that the `groupId` does not exist in the server. Use the group api to get the list of available groups.


## Important Links
- [Traccar Create Device](https://www.traccar.org/api-reference/#tag/Device/paths/~1devices/post)
- [DeviceData DTO reference](./../reference/dto/device-data)
- [DeviceAttributesData DTO reference]( ./../reference/dto/device-attributes-data)