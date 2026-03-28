# Get All Users

Fetch users from your Traccar server, with optional filtering and pagination.

> [!WARNING]
> Can only be used by admin or manager users.

## Request

Use the `ThingsTelemetry\Traccar\Facades\User::all()` method to retrieve users.

```php
use ThingsTelemetry\Traccar\Facades\User;

$users = User::all(); // Illuminate\Support\Collection of ThingsTelemetry\Traccar\Dto\UserData
```

You can also pass Traccar's supported query filters:

```php
use ThingsTelemetry\Traccar\Facades\User;

$users = User::all(
    userId: 3,
    deviceId: 7,
    excludeAttributes: true,
    limit: 25,
    offset: 50,
    keyword: 'jane',
);
```

### Available Parameters

- `userId`: Return users managed by a specific user.
- `deviceId`: Return users linked to a specific device.
- `excludeAttributes`: Exclude the `attributes` field from the response.
- `limit`: Limit the number of returned records.
- `offset`: Skip a number of records before returning results.
- `keyword`: Search users by name or email.

## Result

Returns an `Illuminate\Support\Collection` of `ThingsTelemetry\Traccar\Dto\UserData` instances.

```php
$first = $users->first();
$first->name; // string
```

## Important Links
- [Traccar: Get Users](https://www.traccar.org/api-reference/#tag/Users/paths/~1users/get)
- [UserData DTO reference](./../reference/dto/user-data)
