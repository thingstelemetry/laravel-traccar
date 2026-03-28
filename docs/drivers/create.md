# Create Driver

Create a driver in Traccar.

## Request

```php
use ThingsTelemetry\Traccar\Dto\DriverData;
use ThingsTelemetry\Traccar\Facades\Driver;

$driver = Driver::create(new DriverData(
    name: 'John Doe',
    uniqueId: 'DRV-001',
));
```

## Result

Returns `ThingsTelemetry\Traccar\Dto\DriverData`.

## Important Links
- [Traccar Drivers](https://www.traccar.org/api-reference/#tag/Drivers/paths/~1drivers/post)
