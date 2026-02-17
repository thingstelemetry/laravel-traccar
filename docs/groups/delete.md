# Delete Group

Delete an existing group from your Traccar server.

> [!WARNING]
> Deleting a group is irreversible. Ensure you target the correct group ID. Devices in the group will be ungrouped but not deleted.

## Usage

```php
use ThingsTelemetry\Traccar\Dto\StatusData;
use ThingsTelemetry\Traccar\Facades\Group;
use ThingsTelemetry\Traccar\Enums\Status;

$groupId = 1;

$result = Group::delete(id: $groupId); // returns ThingsTelemetry\Traccar\Dto\StatusData

if ($result->status === Status::SUCCESS) {
    // Successfully deleted
}
```

## Results

The response is a `ThingsTelemetry\Traccar\Dto\StatusData` object containing a `ThingsTelemetry\Traccar\Enums\Status`.

```php
$result->status->value;  // 'success'
$result->status->name;   // 'SUCCESS'
$result->status->label(); // 'Success'
```

## Impact of Deletion

When you delete a group:

- The group is permanently removed
- Devices in the group are **not** deleted, but their `groupId` becomes `null`
- Child groups (nested groups) are **not** deleted, but their `groupId` reference is removed

## Error Handling

```php
use ThingsTelemetry\Traccar\Facades\Group;
use Saloon\Exceptions\Request\RequestException;

try {
    $result = Group::delete(id: 1);
} catch (RequestException $e) {
    $status = $e->getResponse()->status();
    
    match ($status) {
        401 => // Unauthorized - check API credentials,
        403 => // Forbidden - insufficient permissions,
        404 => // Group not found - check group ID,
        default => // Handle other errors
    };
}
```

## Related Operations

- [Get All Groups](./get-all) - Fetch all accessible groups
- [Get Group](./get-information) - Fetch a single group
- [Create Group](./create) - Create a new group
- [Update Group](./update) - Update an existing group

## Important Links

- [Traccar API: Delete a Group](https://www.traccar.org/api-reference/#tag/Group/paths/~1groups~1%7Bid%7D/delete)
- [Status enum reference](./../reference/enums/status)
