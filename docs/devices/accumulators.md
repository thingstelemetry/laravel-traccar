# Update Total Distance and Hours

Update the total distance and engine hours for a specific device.

> [!WARNING]
> - Do not use `uniqueID` inplace of `id` (device id)
> - The device must have at least one position recorded in the database else the update will fail.

## Usage

```php
use TrackTelemetry\Traccar\Dto\StatusData;
use TrackTelemetry\Traccar\Enums\Status;
use TrackTelemetry\Traccar\Facades\Device;

$deviceId = 6;
$totalDistance = 12345.6; // in meters
$hours = 789.0; // hours

$result = Device::updateTotals(deviceId: $deviceId, totalDistance: $totalDistance, hours: $hours); // returns TrackTelemetry\Traccar\Dto\StatusData

if ($result->status === Status::SUCCESS) {
    // Totals updated successfully
}
```

## Results

The response is a `TrackTelemetry\Traccar\Dto\StatusData` object containing a `TrackTelemetry\Traccar\Enums\Status`. A 204 response is treated as success.

```php
$result->status->value; // 'success' or 'failure'
$result->status->label(); // 'Success' or 'Failure'
```

## Errors

### 400 - Bad Request (400) Response: java.lang.IllegalArgumentException

```shell
Bad Request (400) Response: java.lang.IllegalArgumentException at org.traccar.api.resource.DeviceResource.updateAccumulators(DeviceResource.java:183)  
```

This means the device does not have any positions recorded in the database. Record some positions before updating the totals.


## Important Links
- [Traccar Update total distance and hours of the Device](https://www.traccar.org/api-reference/#tag/Devices/paths/~1devices~1%7Bid%7D~1accumulators/put)
- [DeviceData DTO reference](./../reference/dto/device-data)
- [Status enum reference](./../reference/enums/status)
- [Traccar DeviceResource Source](https://github.com/traccar/traccar/blob/e7b9cce18104b4894f98007bf33c7e2e2008de2a/src/main/java/org/traccar/api/resource/DeviceResource.java#L150-L188)
