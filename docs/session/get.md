# Get Session Information

Fetch the current authenticated user's session information.

## Overview

The `Session::get()` method retrieves details about the currently authenticated user. If no valid session exists (i.e., the user is not logged in), the API returns a 404 error.

## Usage

### Basic Usage

Retrieve the current user's session information:

```php
use ThingsTelemetry\Traccar\Facades\Session;

$user = Session::get();
```

### With Token Verification

Optionally pass a token to verify its validity:

```php
use ThingsTelemetry\Traccar\Facades\Session;

$token = 'abc123...';
$user = Session::get($token);
```

## Result

The response is an instance of `ThingsTelemetry\Traccar\Dto\UserData`.

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

### Key Result Fields

- **`id`** → `int` - Unique user identifier
- **`name`** → `string` - User's full name
- **`email`** → `string` - User's email address
- **`administrator`** → `bool` - Whether the user has admin privileges
- **`map`** → [`Map`](../reference/enums/map) - Preferred map provider
- **`coordinateFormat`** → [`CoordinateFormat`](../reference/enums/coordinate-format) - Preferred coordinate format
- **`attributes`** → [`UserAttributesData`](../reference/dto/user-attributes-data) - Additional user attributes

> [!IMPORTANT]
> Refer to the [UserData DTO documentation](../reference/dto/user-data) for complete field documentation.

## Error Handling

- **404 Not Found**: Returned when no valid session exists (user not authenticated)

```php
use ThingsTelemetry\Traccar\Facades\Session;
use Saloon\Exceptions\Request\RequestException;

try {
    $user = Session::get();
} catch (RequestException $e) {
    if ($e->getResponse()->status() === 404) {
        // User is not authenticated
        // Redirect to login page
    }
}
```

## Important Links
- [Traccar API: Get Session](https://www.traccar.org/api-reference/#tag/Session/paths/~1session/get)
- [UserData DTO Reference](../reference/dto/user-data)
