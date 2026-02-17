# Update User

Update an existing user on your Traccar server.

> [!IMPORTANT]
> **Recommended workflow**: fetch the user DTO first, modify only the fields you need, then send the updated DTO. This avoids accidental resets.

## Usage

```php
use ThingsTelemetry\Traccar\Dto\UserData;
use ThingsTelemetry\Traccar\Enums\Map;
use ThingsTelemetry\Traccar\Enums\CoordinateFormat;
use ThingsTelemetry\Traccar\Facades\User;

// 1) Get an existing user
$user = User::get(42);

// 2) Update the fields you want to change
$user->name = 'Jane Doe (Updated)';
$user->map = Map::OSM;
$user->coordinateFormat = CoordinateFormat::DDM;

// 3) Send the updated DTO
$updated = User::update($user); // returns ThingsTelemetry\Traccar\Dto\UserData
```

## Results

```php
$updated->id; // 42
$updated->name; // "Jane Doe (Updated)"
$updated->map->value; // e.g., "osm"
```

## Error Handling

```php
use ThingsTelemetry\Traccar\Facades\User;
use Saloon\Exceptions\Request\RequestException;

try {
    $updated = User::update($user);
} catch (RequestException $e) {
    $status = $e->getResponse()->status();
    
    match ($status) {
        400 => // Bad request - invalid data (e.g., duplicate email),
        401 => // Unauthorized - check API credentials,
        403 => // Forbidden - insufficient permissions,
        404 => // User not found - check user ID,
        default => // Handle other errors
    };
}
```

## Important Links
- [Traccar Update User](https://www.traccar.org/api-reference/#tag/Users/paths/~1users~1%7Bid%7D/put)
- [UserData DTO reference](./../reference/dto/user-data)