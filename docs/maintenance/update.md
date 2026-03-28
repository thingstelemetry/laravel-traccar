# Update Maintenance

Update a maintenance rule in Traccar.

## Request

```php
use ThingsTelemetry\Traccar\Dto\MaintenanceData;
use ThingsTelemetry\Traccar\Facades\Maintenance;

$item = Maintenance::update(new MaintenanceData(
    id: 11,
    name: 'Oil Change',
    type: 'distance',
    start: 0,
    period: 10000,
));
```

## Result

Returns `ThingsTelemetry\Traccar\Dto\MaintenanceData`.

## Important Links
- [Traccar Maintenance](https://www.traccar.org/api-reference/#tag/Maintenance/paths/~1maintenance~1%7Bid%7D/put)
