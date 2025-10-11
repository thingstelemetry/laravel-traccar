# Server Attributes Data Dto Reference

The `TrackTelemetry\Traccar\Dto\ServerAttributesData` represents the **configurable preferences and UI behavior** of a Traccar server instance. It provides structured access to map display settings, unit preferences, API keys, and user interface controls defined in the Traccar configuration.

```php
use TrackTelemetry\Traccar\Facades\Server;

$attributes = Server::getInformation()->attributes;
```

## `language` → `string|null`

Preferred interface language for the server UI.
```php
$attributes->language; // "en"
```

## `mapGeofences` → `boolean`

If true, displays geofences on the server map.
```php
$attributes->mapGeofences; // true
```

## `mapLiveRoutes` → `string|null`

Specifies the live route line color or style for map visualization.
```php
$attributes->mapLiveRoutes; // "#0099FF"
```

## `mapDirection` → `string|null`

Determines whether to show directional arrows on map routes.
```php
$attributes->mapDirection; // "arrows"
```

## `mapFollow` → `boolean`

If true, the map automatically follows active device movement.
```php
$attributes->mapFollow; // true
```

## `mapCluster` → `boolean`

Enables clustering of devices on the map for better visibility.
```php
$attributes->mapCluster; // true
```

## `mapOnSelect` → `boolean`

If true, selecting a device pans the map to its location.
```php
$attributes->mapOnSelect; // false
```

## `activeMapStyles` → `string|null`

Specifies the active map style or theme (e.g., “dark”, “satellite”).
```php
$attributes->activeMapStyles; // "dark"
```

## `devicePrimary` → `string|null`

Primary device attribute to show in the list view.
```php
$attributes->devicePrimary; // "name"
```

## `deviceSecondary` → `string|null`

Secondary attribute displayed under device name.
```php
$attributes->deviceSecondary; // "status"
```

## `soundEvents` → `mixed`

Event notification sound identifier.
```php
$attributes->soundEvents; // "??"
```

## `soundAlarms` → `mixed`

Alarm notification sound file or key.
```php
$attributes->soundAlarms; // "??"
```

## `positionItems` → `string|null`

Defines how position items are displayed (e.g., “table” or “list”).
```php
$attributes->positionItems; // "table"
```

## `googleKey`, `locationIqKey`, `mapboxAccessToken`, `mapTilerKey`, `bingMapsKey`, `openWeatherKey`, `tomTomKey`, `hereKey` → `string|null`

API keys for external integrations such as maps, weather, and geocoding services.
```php
$attributes->mapboxAccessToken; // "MAPBOX_TOKEN"
```

## `notificationTokens` → `string|null`

Comma-separated tokens for push notification services.
```php
$attributes->notificationTokens; // "TOKEN1,TOKEN2"
```

## `uiDisableSavedCommands`, `uiDisableGroups`, `uiDisableAttributes`, `uiDisableEvents`, `uiDisableVehicleFeatures`, `uiDisableDrivers`, `uiDisableComputedAttributes`, `uiDisableCalendars`, `uiDisableMaintenance` → `boolean`

Flags controlling which UI sections or features are hidden/disabled in the web interface.
```php
$attributes->uiDisableGroups; // false
```

## `webLiveRouteLength` → `integer|null`

Maximum number of points to render in live routes.
```php
$attributes->webLiveRouteLength; // 1000
```

## `mapLineWidth` → `float|null`

Width of lines drawn for device routes on the map.
```php
$attributes->mapLineWidth; // 2.5
```

## `mapLineOpacity` → `float|null`

Opacity (0–1) of map route lines.
```php
$attributes->mapLineOpacity; // 0.8
```

## `webSelectZoom` → `integer|null`

Default zoom level when selecting a device.
```php
$attributes->webSelectZoom; // 15
```

## `webMaxZoom` → `integer|null`

Maximum zoom level allowed in the web UI map.
```php
$attributes->webMaxZoom; // 19
```

## `iconScale` → `float|null`

Scaling factor for map device icons.
```php
$attributes->iconScale; // 1.2
```

## `navigationAppLink` → `string|null`

Custom deep link for external navigation apps.
```php
$attributes->navigationAppLink; // "geo:{lat},{lon}"
```

## `navigationAppTitle` → `string|null`

Display title for the external navigation app.
```php
$attributes->navigationAppTitle; // "Google Maps"
```

## `speedUnit` → [`SpeedUnit`](../enums/speed-unit)

Speed measurement unit (e.g., knots, km/h, mph).
```php
$attributes->speedUnit->value; // "kn"
```

## `distanceUnit` → [`DistanceUnit`](../enums/distance-unit)

Distance measurement unit for reports and map metrics.
```php
$attributes->distanceUnit->label(); // "Kilometers"
```

## `altitudeUnit` → [`AltitudeUnit`](../enums/altitude-unit)

Preferred unit for altitude readings.
```php
$attributes->altitudeUnit->value; // "m"
```

## `volumeUnit` → [`VolumeUnit`](../enums/volume-unit)

Volume measurement unit (used in fuel level sensors, etc.).
```php
$attributes->volumeUnit->value; // "l"
```

## `timezone` → `string`

Default timezone for server and reports.
```php
$attributes->timezone; // "Africa/Nairobi"
```

> [!IMPORTANT]
> Null boolean attributes defaults to false.