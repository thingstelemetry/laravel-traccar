# Get Session by User ID

Create a session for a specific user by their ID.

## Overview

The `Session::getById()` method creates a new session for the specified user. This endpoint is primarily used for administrative purposes such as user impersonation or support scenarios.

> [!WARNING]
> This endpoint requires administrative or manager permissions. Regular users will receive a 403 Forbidden error.

## Usage

```php
use ThingsTelemetry\Traccar\Facades\Session;

$userId = 42;
$user = Session::getById($userId);
```

## Result

The response is an instance of `ThingsTelemetry\Traccar\Dto\UserData` containing the user's information.

```php
$user->id; // 42
$user->name; // "Jane Doe"
$user->email; // "jane@example.com"
$user->administrator; // true|false
$user->map->value; // "osm"
$user->attributes->toArray(); // array<string, mixed>
```

## Important Notes

- This method is intended for administrative use cases
- Only administrators and managers can create sessions for other users
- The created session will have the same permissions as the target user
- Useful for debugging user-specific issues or providing support

## Important Links
- [Traccar API: Get Session by ID](https://www.traccar.org/api-reference/#tag/Session/paths/~1session~1{id}/get)
- [UserData DTO Reference](../reference/dto/user-data)
