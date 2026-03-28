# Update Driver

Update an existing driver in Traccar.

## Request

```php
use ThingsTelemetry\Traccar\Dto\DriverData;
use ThingsTelemetry\Traccar\Facades\Driver;

$driver = Driver::update(new DriverData(
    id: 9,
    name: 'John Doe',
    uniqueId: 'DRV-001',
));
```

## Result

Returns `ThingsTelemetry\Traccar\Dto\DriverData`.

## Important Links
- [Traccar Drivers](https://www.traccar.org/api-reference/#tag/Drivers/paths/~1drivers~1%7Bid%7D/put)
