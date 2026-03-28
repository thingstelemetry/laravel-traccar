# Delete Maintenance

Delete a maintenance rule from Traccar.

## Request

```php
use ThingsTelemetry\Traccar\Facades\Maintenance;

$result = Maintenance::delete(id: 11);
```

## Result

Returns `ThingsTelemetry\Traccar\Dto\StatusData`.

## Important Links
- [Traccar Maintenance](https://www.traccar.org/api-reference/)
