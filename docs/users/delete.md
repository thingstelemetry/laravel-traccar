# Delete User

Delete an existing user from your Traccar server.

> [!WARNING]
> Deleting a user is irreversible. Ensure you target the correct user ID.

## Usage

```php
use ThingsTelemetry\Traccar\Dto\StatusData;
use ThingsTelemetry\Traccar\Facades\User;
use ThingsTelemetry\Traccar\Enums\Status;

$userId = 6;

$result = User::delete(id: $userId); // returns ThingsTelemetry\Traccar\Dto\StatusData

if ($result->status === Status::SUCCESS) {
    // Successfully deleted
}
```

## Results

The response is a `ThingsTelemetry\Traccar\Dto\StatusData` object containing a `ThingsTelemetry\Traccar\Enums\Status`.

```php
$result->status->value; // 'success' or 'failure'
$result->status->name;  // 'SUCCESS' or 'FAILURE'
$result->status->label(); // 'Success' or 'Failure'
```

## Important Links
- [Traccar Delete User](https://www.traccar.org/api-reference/#tag/Users/paths/~1users~1%7Bid%7D/delete)
- [Status enum reference](./../reference/enums/status)