# Create Geofence

Create a geofence in Traccar.

## Request

```php
use ThingsTelemetry\Traccar\Dto\GeofenceData;
use ThingsTelemetry\Traccar\Facades\Geofence;

$geofence = Geofence::create(new GeofenceData(
    name: 'Warehouse',
    description: 'Main depot',
    area: 'POLYGON ((36.8 -1.2, 36.9 -1.2, 36.9 -1.3, 36.8 -1.3, 36.8 -1.2))',
));
```

## Result

Returns `ThingsTelemetry\Traccar\Dto\GeofenceData`.

## Important Links
- [Traccar Geofences](https://www.traccar.org/api-reference/#tag/Geofences/paths/~1geofences/post)
