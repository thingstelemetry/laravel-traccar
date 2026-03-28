# Update Group

Update an existing group on your Traccar server.

> [!IMPORTANT]
> Recommended workflow: fetch the group DTO first, update the fields you need, then send the updated DTO.
> This preserves fields you are not changing and avoids accidental resets.
>
> - The `id` field is required for updates
> - Only update the fields you want to change

## Usage

```php
use ThingsTelemetry\Traccar\Dto\GroupData;
use ThingsTelemetry\Traccar\Facades\Group;

// 1) Get an existing group
$group = Group::find(1); // ThingsTelemetry\Traccar\Dto\GroupData

// 2) Create a copy with updated values
$updatedData = new GroupData(
    id: $group->id,
    name: 'Updated Name',
    groupId: $group->groupId,
    attributes: array_merge($group->attributes, [
        'color' => 'green',
    ]),
);

// 3) Send the updated DTO
$updated = Group::update($updatedData); // returns ThingsTelemetry\Traccar\Dto\GroupData
```

## Results

The response is a `ThingsTelemetry\Traccar\Dto\GroupData` instance with the updated data.

```php
$updated->id;          // 1
$updated->name;        // "Updated Name"
$updated->groupId;     // null
$updated->attributes;  // ['color' => 'green', ...]
```

## Updating Attributes

You can update only the attributes while preserving other fields:

```php
$group = Group::find(1);

$updatedData = new GroupData(
    id: $group->id,
    name: $group->name,
    groupId: $group->groupId,
    attributes: [
        'color' => 'red',
        'icon' => 'motorcycle',
        'newAttribute' => 'value',
    ],
);

$updated = Group::update($updatedData);
```

## Changing Parent Group

Move a group to a different parent:

```php
$group = Group::find(2);

$updatedData = new GroupData(
    id: $group->id,
    name: $group->name,
    groupId: 5, // New parent group ID
    attributes: $group->attributes,
);

$updated = Group::update($updatedData);
```

To make a group top-level (remove parent):

```php
$updatedData = new GroupData(
    id: $group->id,
    name: $group->name,
    groupId: null, // Remove parent
    attributes: $group->attributes,
);
```

## Errors

### InvalidArgumentException - Group ID required

```php
// This will throw an exception
$groupData = new GroupData(name: 'No ID');
Group::update($groupData); // InvalidArgumentException: Group ID is required for update operations.
```

### 400 - Parent group not found

```shell
Bad Request (400) Response: Key (groupid)=(9999) is not present in table "tc_groups".
```

The specified `groupId` (parent) does not exist.

## Related Operations

- [Get All Groups](./all) - Fetch all accessible groups
- [Get Group](./find) - Fetch a single group
- [Create Group](./create) - Create a new group
- [Delete Group](./delete) - Remove a group

## Important Links

- [Traccar API: Update a Group](https://www.traccar.org/api-reference/#tag/Group/paths/~1groups~1%7Bid%7D/put)
- [GroupData DTO reference](./../reference/dto/group-data)
