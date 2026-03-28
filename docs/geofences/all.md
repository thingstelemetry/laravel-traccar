# Get All Geofences

Fetch geofences from your Traccar server.

## Request

```php
use ThingsTelemetry\Traccar\Facades\Geofence;

$geofences = Geofence::all(all: true, deviceId: 6);
```

## Result

Returns an `Illuminate\Support\Collection<int, ThingsTelemetry\Traccar\Dto\GeofenceData>`.

## Important Links
- [Traccar Geofences](https://www.traccar.org/api-reference/)
