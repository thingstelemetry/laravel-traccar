# Delete Geofence

Delete a geofence from Traccar.

## Request

```php
use ThingsTelemetry\Traccar\Facades\Geofence;

$result = Geofence::delete(id: 15);
```

## Result

Returns `ThingsTelemetry\Traccar\Dto\StatusData`.

## Important Links
- [Traccar Geofences](https://www.traccar.org/api-reference/#tag/Geofences/paths/~1geofences~1%7Bid%7D/delete)
