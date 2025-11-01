# Create User

Create a user on your Traccar server.

> [!IMPORTANT]
> - Only admin or manager users can create users.
> - `id` is ignored if set. Traccar will generate a new ID.

## Usage

```php
use TrackTelemetry\Traccar\Dto\UserData;
use TrackTelemetry\Traccar\Dto\UserAttributesData;
use TrackTelemetry\Traccar\Enums\Map;
use TrackTelemetry\Traccar\Enums\CoordinateFormat;
use TrackTelemetry\Traccar\Facades\User;

$attributes = new UserAttributesData(
    language: 'en',
    mapGeofences: true,
);

$data = new UserData(
    id: 0, // ignored on create
    name: 'Jane Doe',
    email: 'jane@example.com',
    phone: '+15551234567',
    readonly: false,
    administrator: false,
    map: Map::OSM,
    latitude: 0.0,
    longitude: 0.0,
    zoom: 0,
    password: 'secret',
    coordinateFormat: CoordinateFormat::DD,
    disabled: false,
    expirationTime: null,
    deviceLimit: 0,
    userLimit: 0,
    deviceReadonly: false,
    limitCommands: false,
    fixedEmail: false,
    poiLayer: null,
    attributes: $attributes,
);

$created = User::create($data); // returns TrackTelemetry\Traccar\Dto\UserData
```

## Results

The response is a `TrackTelemetry\Traccar\Dto\UserData` instance.

```php
$created->id;            // int
$created->name;          // "Jane Doe"
$created->email;         // "jane@example.com"
$created->map->value;    // "osm"
$created->attributes->toArray();
```

## Important Links
- [Traccar Create User](https://www.traccar.org/api-reference/#tag/Users/paths/~1users/post)
- [UserData DTO reference](./../reference/dto/user-data)
- [UserAttributesData DTO reference](./../reference/dto/user-attributes-data)