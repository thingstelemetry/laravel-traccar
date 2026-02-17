# Create User

Create a user on your Traccar server.

> [!IMPORTANT]
> - Only admin or manager users can create users.
> - `id` is ignored if set. Traccar will generate a new ID.

## Usage

```php
use ThingsTelemetry\Traccar\Dto\UserData;
use ThingsTelemetry\Traccar\Dto\UserAttributesData;
use ThingsTelemetry\Traccar\Enums\Map;
use ThingsTelemetry\Traccar\Enums\CoordinateFormat;
use ThingsTelemetry\Traccar\Facades\User;

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

$created = User::create($data); // returns ThingsTelemetry\Traccar\Dto\UserData
```

## Results

The response is a `ThingsTelemetry\Traccar\Dto\UserData` instance.

```php
$created->id;            // int
$created->name;          // "Jane Doe"
$created->email;         // "jane@example.com"
$created->map->value;    // "osm"
$created->attributes->toArray();
```

## Error Handling

```php
use ThingsTelemetry\Traccar\Facades\User;
use Saloon\Exceptions\Request\RequestException;

try {
    $created = User::create($data);
} catch (RequestException $e) {
    $status = $e->getResponse()->status();
    
    match ($status) {
        400 => // Bad request - invalid data (e.g., email already exists),
        401 => // Unauthorized - check API credentials,
        403 => // Forbidden - requires admin or manager role,
        default => // Handle other errors
    };
}
```

## Important Links
- [Traccar Create User](https://www.traccar.org/api-reference/#tag/Users/paths/~1users/post)
- [UserData DTO reference](./../reference/dto/user-data)
- [UserAttributesData DTO reference](./../reference/dto/user-attributes-data)