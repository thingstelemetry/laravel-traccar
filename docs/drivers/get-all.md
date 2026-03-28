# Get All Drivers

Fetch drivers from your Traccar server.

## Request

```php
use ThingsTelemetry\Traccar\Facades\Driver;

$drivers = Driver::getAll(all: true, deviceId: 6);
```

## Result

Returns an `Illuminate\Support\Collection<int, ThingsTelemetry\Traccar\Dto\DriverData>`.

## Important Links
- [Traccar Drivers](https://www.traccar.org/api-reference/#tag/Drivers/paths/~1drivers/get)
