# Link Permissions (Bulk)

Link multiple object pairs at once for efficient batch operations.

## Usage

Use the `ThingsTelemetry\Traccar\Facades\Permission::linkBulk()` method to create multiple permission relationships in a single request.

```php
use ThingsTelemetry\Traccar\Facades\Permission;
use ThingsTelemetry\Traccar\Dto\PermissionData;

$permissions = [
    new PermissionData(userId: 5, deviceId: 10),
    new PermissionData(userId: 5, deviceId: 11),
    new PermissionData(userId: 5, deviceId: 12),
];

$result = Permission::linkBulk($permissions);

if ($result->status->value === 'success') {
    echo "All permissions linked successfully";
}
```

## Common Use Cases

### Grant User Access to Multiple Devices

```php
use ThingsTelemetry\Traccar\Facades\Permission;
use ThingsTelemetry\Traccar\Dto\PermissionData;

$deviceIds = [10, 11, 12, 13, 14];
$permissions = array_map(
    fn ($deviceId) => new PermissionData(userId: 5, deviceId: $deviceId),
    $deviceIds
);

Permission::linkBulk($permissions);
```

### Grant Multiple Users Access to a Device

```php
$userIds = [5, 6, 7, 8];
$permissions = array_map(
    fn ($userId) => new PermissionData(userId: $userId, deviceId: 10),
    $userIds
);

Permission::linkBulk($permissions);
```

### Setup User with Multiple Permissions

```php
$permissions = [
    new PermissionData(userId: 5, deviceId: 10),
    new PermissionData(userId: 5, groupId: 2),
    new PermissionData(userId: 5, geofenceId: 3),
    new PermissionData(userId: 5, notificationId: 7),
];

Permission::linkBulk($permissions);
```

### Link Multiple Devices to a Geofence

```php
$deviceIds = [10, 11, 12];
$permissions = array_map(
    fn ($deviceId) => new PermissionData(deviceId: $deviceId, geofenceId: 3),
    $deviceIds
);

Permission::linkBulk($permissions);
```

## Important Notes

- Each `PermissionData` in the array must have exactly **2 parameters**
- All permissions must be valid for the operation to succeed
- If any permission fails, the entire batch may fail (atomic operation)
- Bulk operations are more efficient than individual link calls for large datasets

## Related Operations

- [Link Permission](./link) - Link a single permission
- [Unlink Permission](./unlink) - Remove a single permission
- [Unlink Permissions (Bulk)](./unlink-bulk) - Remove multiple permissions at once

## Important Links

- [Traccar API: Permissions](https://www.traccar.org/api-reference/#tag/Permissions)
- [PermissionData DTO reference](./../reference/dto/permission-data)
