# Retrieve User Information

Fetch a specific user by ID from your Traccar server.

> [!WARNING]
> Can only be used by admin or manager users.

## Request

Use the `TrackTelemetry\Traccar\Facades\User::get(int $id)` method to retrieve a single user.

```php
use TrackTelemetry\Traccar\Facades\User;

$user = User::get(42); // TrackTelemetry\Traccar\Dto\UserData
```

## Result

The response is an instance of `TrackTelemetry\Traccar\Dto\UserData`.

```php
$user->id; // 42
$user->name; // "Jane Doe"
$user->email; // "jane@example.com"
$user->administrator; // true|false
$user->map->value; // "osm"
$user->coordinateFormat; // enum CoordinateFormat
$user->expirationTime?->toIso8601String();
$user->attributes->toArray(); // array<string, mixed>
```

## Important Links
- [Traccar: Get User by ID](https://www.traccar.org/api-reference/#tag/Users/paths/~1users/get)
- [UserData DTO reference](./../reference/dto/user-data)