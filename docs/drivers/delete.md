# Delete Driver

Delete a driver from Traccar.

## Request

```php
use ThingsTelemetry\Traccar\Facades\Driver;

$result = Driver::delete(id: 9);
```

## Result

Returns `ThingsTelemetry\Traccar\Dto\StatusData`.

## Important Links
- [Traccar Drivers](https://www.traccar.org/api-reference/#tag/Drivers/paths/~1drivers~1%7Bid%7D/delete)
