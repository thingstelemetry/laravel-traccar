# Update Device

Update an existing device on your Traccar server.

> [!IMPORTANT]
> Recommended workflow: fetch the device DTO first, clone it, update the fields you need, then send the updated DTO.
> This preserves fields you are not changing and avoids accidental resets. See the server update docs for the same pattern.
>
> - Only update the fields you want to change
> - Keep the `id` and `uniqueId` consistent with the target device

## Usage

```php
use TrackTelemetry\Traccar\Dto\DeviceData;
use TrackTelemetry\Traccar\Dto\DeviceAttributesData;
use TrackTelemetry\Traccar\Enums\DeviceCategory;
use TrackTelemetry\Traccar\Enums\DeviceStatus;
use TrackTelemetry\Traccar\Facades\Device;

// 1) Get an existing device (example: by uniqueId)
$devices = Device::get(uniqueIds: ['ABC123']);
$device = $devices->first(); // TrackTelemetry\Traccar\Dto\DeviceData

// 2) Clone the DTO so you can safely mutate values
$data = DeviceData::fromArray($device->toArray());

// 3) Update the clone as needed
$data->name = 'Truck 1 - Updated';
$data->attributes->speedLimit = 90.0;

// 4) Send the updated DTO
$updated = Device::update($data); // returns TrackTelemetry\Traccar\Dto\DeviceData
```

## Results

The response is a `TrackTelemetry\Traccar\Dto\DeviceData` instance.

```php
$name = $updated->name;                  // "Truck 1 - Updated"
$status = $updated->status->label();     // e.g., "Online"
$category = $updated->category->value;   // e.g., "truck"
$lastSeen = $updated->lastUpdate?->toIso8601String();

$speedLimit = $updated->attributes->speedLimit; // 90.0
```


## Errors

### 400 - Key (groupid)=(123456) is not present in table "tc_groups"

```shell
Bad Request (400) Response: org.traccar.storage.StorageException: org.postgresql.util.PSQLException: ERROR: duplicate key value violates unique constraint "tc_devices_uniqueid_key" Detail: Key (uniqueid)=(AX3WX9XT6ZYMPQWJ) already exists
```
This means a device with the given `uniqueid` already exists in the server. Get the device details instead or use a different `uniqueid`.


## Important Links
- [Traccar Update a Device](https://www.traccar.org/api-reference/#tag/Devices/paths/~1devices~1%7Bid%7D/put)
- See the same [clone-update-send workflow](./../server/update-information)
- [DeviceData DTO reference](./../reference/dto/device-data)
- [DeviceAttributesData DTO reference](./../reference/dto/device-attributes-data)
