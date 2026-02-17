# Get All Groups

Fetch the list of groups from your Traccar server.

> [!WARNING]
> Standard users can only view groups they have access to. Admins and managers can view all groups.

## Usage

### Basic Usage

Use the `ThingsTelemetry\Traccar\Facades\Group::getAll()` method to retrieve all accessible groups.

```php
use ThingsTelemetry\Traccar\Facades\Group;

$groups = Group::getAll(); // Illuminate\Support\Collection of GroupData
```

### With Filters

```php
use ThingsTelemetry\Traccar\Facades\Group;

// Get all groups (admin/manager only)
$groups = Group::getAll(all: true);

// Get groups for a specific user
$groups = Group::getAll(userId: 42);

// Get groups without attributes (lighter response)
$groups = Group::getAll(excludeAttributes: true);

// Combine filters
$groups = Group::getAll(all: true, userId: 42, excludeAttributes: true);
```

## Query Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `all` | `?bool` | If true, returns all groups (admin/manager only) |
| `userId` | `?int` | Filter groups accessible by a specific user |
| `excludeAttributes` | `?bool` | If true, excludes attributes from response for better performance |

## Results

The response is a `Illuminate\Support\Collection<int, ThingsTelemetry\Traccar\Dto\GroupData>`.

```php
$first = $groups->first();

$id = $first->id;             // 1
$name = $first->name;         // "Vehicles"
$groupId = $first->groupId;   // null (top-level group)
$attributes = $first->attributes; // ['color' => 'blue']
```

### Key Result Items

- `id` → `?int`
  Unique identifier for the group.
- `name` → `string`
  Human-readable group name.
- `groupId` → `?int`
  Parent group ID for hierarchical groups (null for top-level).
- `attributes` → `array<string, mixed>`
  Custom attributes associated with the group.

## Error Handling

```php
use ThingsTelemetry\Traccar\Facades\Group;
use Saloon\Exceptions\Request\RequestException;

try {
    $groups = Group::getAll(all: true);
} catch (RequestException $e) {
    $status = $e->getResponse()->status();
    
    match ($status) {
        401 => // Unauthorized - check API credentials,
        403 => // Forbidden - insufficient permissions (all param requires admin),
        default => // Handle other errors
    };
}
```

## Hierarchical Groups

Groups can be nested. Check the `groupId` property to determine parent-child relationships:

```php
$groups = Group::getAll();

$topLevel = $groups->filter(fn ($g) => $g->groupId === null);
$children = $groups->filter(fn ($g) => $g->groupId === 1);
```

## Related Operations

- [Get Group](./get-information) - Fetch a single group by ID
- [Create Group](./create) - Create a new group
- [Update Group](./update) - Update an existing group
- [Delete Group](./delete) - Remove a group

## Important Links

- [Traccar API: Fetch a list of Groups](https://www.traccar.org/api-reference/#tag/Group/paths/~1groups/get)
- [GroupData DTO reference](./../reference/dto/group-data)
