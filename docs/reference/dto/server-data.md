# Server Data Dto Reference

The `ThingsTelemetry\Traccar\Dto\ServerData` represents the Traccar server configuration and system metadata. This class provides typed access to server attributes, map preferences, storage information, and other settings.


```php
use ThingsTelemetry\Traccar\Facades\Server;

$info = Server::getInformation(); 
```

## `id` → `integer`

Traccar server entity identifier.
```php
$id = $info->id; // 1
```

## `attributes` → [`ServerAttributesData`](./server-attributes-data)

Typed server attributes & preferences (units, timezones, UI flags). Instance of `ThingsTelemetry\Traccar\Dto\ServerAttributesData`
```php
$attributes = $info->attributes; // instance of ServerAttributesData
```
> [!IMPORTANT]
> Please see [Server Attributes Data](./server-attributes-data) for more details.

## `registration` → `boolean`

Whether new user registration is enabled on Traccar server.
```php
$info->registration; // true
```

## `readonly` → `boolean`

If true, server configuration changes are read-only.
```php
$info->readonly; // false
```

## `deviceReadonly` → `boolean`

Whether devices themselves are read-only (cannot be edited).
```php
$info->deviceReadonly; // true
```

## `map` → [`Map`](../enums/map)

Traccar map provider (enum). Instance of `ThingsTelemetry\Traccar\Enums\Map`
```php
$info->map->value;   // "osm"
$info->map->label(); // "OpenStreetMap"
```

## `bingKey` → `string|null`

Bing Maps API key (if configured).
```php
$info->bingKey; // null or "BING_API_KEY"
```

## `mapUrl` → `string|null`

Custom tile base URL for maps (if set).
```php
$info->mapUrl; // "https://tiles.example.com/{z}/{x}/{y}.png"
```

## `overlayUrl` → `string|null`

Optional overlay tiles URL for extra map layers.
```php
$info->overlayUrl; // "https://overlays.example.com/{z}/{x}/{y}.png"
```

## `latitude` → `float`

Default map center latitude.
```php
$info->latitude; // -1.2921
```

## `longitude` → `float`

Default map center longitude.
```php
$info->longitude; // 36.8219
```

## `zoom` → `integer`

Default map zoom level.
```php
$info->zoom; // 10
```

## `forceSettings` → `boolean`

If true, clients must use server-provided settings.
```php
$info->forceSettings; // true
```

## `coordinateFormat` → [`CoordinateFormat`](../enums/coordinate-format)

Preferred coordinate display format (enum). Instance of `ThingsTelemetry\Traccar\Enums\CoordinateFormat`
```php
$info->coordinateFormat->value;   // "dd"
$info->coordinateFormat->label(); // "Decimal Degrees"
```

## `limitCommands` → `boolean`

Whether command execution is limited by server policies/permissions.
```php
$info->limitCommands; // false
```

## `disableReports` → `boolean`

If true, reporting features are disabled on Traccar server.
```php
$info->disableReports; // false
```

## `fixedEmail` → `boolean`

If true, user email is fixed and cannot be changed.
```php
$info->fixedEmail; // true
```

## `poiLayer` → `string|null`

Points-of-interest layer identifier or URL (if any).
```php
$info->poiLayer; // "poi-layer" or null
```

## `announcement` → `string|null`

Global announcement text to show to users.
```php
$info->announcement; // "System maintenance on Sunday."
```

## `emailEnabled` → `boolean`

Whether email notifications/features are enabled.
```php
$info->emailEnabled; // true
```

## `geocoderEnabled` → `boolean`

Whether reverse geocoding (address lookup) is enabled.
```php
$info->geocoderEnabled; // true
```

## `textEnabled` → `boolean`

Whether text/SMS notifications are enabled.
```php
$info->textEnabled; // false
```

## `storageSpace` → `StorageInfo`

Instance of `ThingsTelemetry\Traccar\Support` structured storage class.
```php
$info->storageSpace->formatted();
// [
//   [
//      'free' => '9.23 GB',
//      'total' => '58.93 GB',
//      'used' => '49.7 GB',
//      'free_percent' => '15.73%'
//   ],
// ]
```

## `newServer` → `boolean`

Indicates the server is new.
```php
$info->newServer; // false
```

## `openIdEnabled` → `boolean`

Whether OpenID authentication is enabled.
```php
$info->openIdEnabled; // true
```

## `openIdForce` → `boolean`

If true, OpenID auth is enforced for sign-in.
```php
$info->openIdForce; // false
```

## `version` → `string`

Traccar server version string.
```php
$info->version; // "6.10.0"
```