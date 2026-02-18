# Get Group Information

Fetch a specific group by ID from your Traccar server.

> [!WARNING]
> Standard users can only access groups they have been granted access to. Admins and managers can access any group.

## Usage

Use the `ThingsTelemetry\Traccar\Facades\Group::get(int $id)` method to retrieve a single group.

```php
use ThingsTelemetry\Traccar\Facades\Group;

$group = Group::get(1); // ThingsTelemetry\Traccar\Dto\GroupData
```

## Result

The response is an instance of `ThingsTelemetry\Traccar\Dto\GroupData`.

```php
$group->id;          // 1
$group->name;        // "Vehicles"
$group->groupId;     // null (top-level group)
$group->attributes;  // ['color' => 'blue', 'icon' => 'truck']
```

### Key Result Items

- `id` → `?int`
  Unique group identifier.
- `name` → `string`
  Human-readable group name.
- `groupId` → `?int`
  Parent group ID (null for top-level groups).
- `attributes` → `array<string, mixed>`
  Custom attributes for the group.

## Related Operations

- [Get All Groups](./get-all) - Fetch all accessible groups
- [Create Group](./create) - Create a new group
- [Update Group](./update) - Update an existing group
- [Delete Group](./delete) - Remove a group

## Important Links

- [Traccar API: Get Group by ID](https://www.traccar.org/api-reference/#tag/Group/paths/~1groups~1%7Bid%7D/get)
- [GroupData DTO reference](./../reference/dto/group-data)
