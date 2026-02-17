# Get All Users

Fetch all users from your Traccar server.

> [!WARNING]
> Can only be used by admin or manager users.

## Request

Use the `ThingsTelemetry\Traccar\Facades\User::all()` method to retrieve all users.

```php
use ThingsTelemetry\Traccar\Facades\User;

$users = User::all(); // array of ThingsTelemetry\Traccar\Dto\UserData
```

## Result

Returns an array of `ThingsTelemetry\Traccar\Dto\UserData` instances.

```php
$first = $users[0];
$first->name; // string
```

## Error Handling

```php
use ThingsTelemetry\Traccar\Facades\User;
use Saloon\Exceptions\Request\RequestException;

try {
    $users = User::all();
} catch (RequestException $e) {
    $status = $e->getResponse()->status();
    
    match ($status) {
        401 => // Unauthorized - check API credentials,
        403 => // Forbidden - requires admin or manager role,
        default => // Handle other errors
    };
}
```

## Important Links
- [Traccar: Get User by ID](https://www.traccar.org/api-reference/#tag/Users/paths/~1users/get)
- [UserData DTO reference](./../reference/dto/user-data)