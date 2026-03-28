# Get All Maintenance

Fetch maintenance records from your Traccar server.

## Request

```php
use ThingsTelemetry\Traccar\Facades\Maintenance;

$items = Maintenance::all(all: true, deviceId: 6);
```

## Result

Returns an `Illuminate\Support\Collection<int, ThingsTelemetry\Traccar\Dto\MaintenanceData>`.

## Important Links
- [Traccar Maintenance](https://www.traccar.org/api-reference/#tag/Maintenance/paths/~1maintenance/get)
