# Group Data DTO Reference

The `ThingsTelemetry\Traccar\Dto\GroupData` represents a Traccar group entity with typed fields. It is used for both reading groups and constructing payloads for create/update operations.

```php
use ThingsTelemetry\Traccar\Facades\Group;

$groups = Group::all(); // Illuminate\Support\Collection<GroupData>
$group = $groups->first();
```

Creating a new DTO for create operations:

```php
use ThingsTelemetry\Traccar\Dto\GroupData;

$dto = new GroupData(
    name: 'Fleet Vehicles',
    attributes: ['color' => 'blue'],
);
```

Creating a DTO for update operations:

```php
$dto = new GroupData(
    id: 1,
    name: 'Updated Name',
    groupId: 5,
    attributes: ['color' => 'green'],
);
```

## `id` → `int`|`null`

Traccar group identifier. Null until the group is created by the server.

```php
$group->id; // 1
```

## `name` → `string`

Human-readable group name.

```php
$group->name; // "Vehicles"
```

## `groupId` → `int`|`null`

Parent group ID for hierarchical groups. `null` for top-level groups.

```php
$group->groupId; // 5 (parent group) or null (top-level)
```

Use this to create nested group structures:

```php
use ThingsTelemetry\Traccar\Facades\Group;

// Create parent group on server first
$fleet = Group::create(new GroupData(name: 'Fleet'));

// Create child group with parent reference
$trucks = Group::create(new GroupData(name: 'Trucks', groupId: $fleet->id));
```

## `attributes` → `array<string, mixed>`

Custom attributes associated with the group. This is a flexible array for storing any metadata.

```php
$group->attributes; // ['color' => 'blue', 'icon' => 'truck']
```

Setting attributes:

```php
$dto = new GroupData(
    name: 'Delivery Fleet',
    attributes: [
        'color' => 'blue',
        'icon' => 'truck',
        'description' => 'Main delivery vehicles',
        'location' => 'Nairobi Depot',
    ],
);
```

## Serialization

### `fromArray(array $data): self`

Create a DTO from an array:

```php
$group = GroupData::fromArray([
    'id' => 1,
    'name' => 'Vehicles',
    'groupId' => null,
    'attributes' => ['color' => 'blue'],
]);
```

### `toArray(): array`

Convert the DTO to an array:

```php
$group->toArray();
// [
//     'id' => 1,
//     'name' => 'Vehicles',
//     'groupId' => null,
//     'attributes' => ['color' => 'blue'],
// ]
```

This is useful for debugging or when you need to inspect the raw data structure.

## Complete Example

```php
use ThingsTelemetry\Traccar\Dto\GroupData;
use ThingsTelemetry\Traccar\Facades\Group;

// Create a parent group
$fleet = Group::create(new GroupData(
    name: 'Fleet',
    attributes: ['description' => 'Main fleet'],
));

// Create child groups
Group::create(new GroupData(
    name: 'Trucks',
    groupId: $fleet->id,
    attributes: ['color' => 'blue', 'icon' => 'truck'],
));

Group::create(new GroupData(
    name: 'Cars',
    groupId: $fleet->id,
    attributes: ['color' => 'red', 'icon' => 'car'],
));

// List all groups
$groups = Group::all();

// Find top-level groups
$topLevel = $groups->filter(fn ($g) => $g->groupId === null);

// Find children of a specific group
$children = $groups->filter(fn ($g) => $g->groupId === $fleet->id);
```

## Related Operations

- [Get All Groups](./../../groups/all) - Fetch all accessible groups
- [Get Group](./../../groups/find) - Fetch a single group
- [Create Group](./../../groups/create) - Create a new group
- [Update Group](./../../groups/update) - Update an existing group
- [Delete Group](./../../groups/delete) - Remove a group
