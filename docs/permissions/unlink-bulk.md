# Unlink Permissions (Bulk)

Remove multiple permission relationships at once for efficient batch operations.

## Usage

Use the `ThingsTelemetry\Traccar\Facades\Permission::unlinkBulk()` method to remove multiple permission relationships in a single request.

```php
use ThingsTelemetry\Traccar\Facades\Permission;
use ThingsTelemetry\Traccar\Dto\PermissionData;

$permissions = [
    new PermissionData(userId: 5, deviceId: 10),
    new PermissionData(userId: 5, deviceId: 11),
    new PermissionData(userId: 5, deviceId: 12),
];

$result = Permission::unlinkBulk($permissions);

if ($result->status->value === 'success') {
    echo "All permissions unlinked successfully";
}
```

## Common Use Cases

### Remove User's Access to Multiple Devices

```php
use ThingsTelemetry\Traccar\Facades\Permission;
use ThingsTelemetry\Traccar\Dto\PermissionData;

$deviceIds = [10, 11, 12, 13, 14];
$permissions = array_map(
    fn ($deviceId) => new PermissionData(userId: 5, deviceId: $deviceId),
    $deviceIds
);

Permission::unlinkBulk($permissions);
```

### Remove Multiple Users' Access to a Device

```php
$userIds = [5, 6, 7, 8];
$permissions = array_map(
    fn ($userId) => new PermissionData(userId: $userId, deviceId: 10),
    $userIds
);

Permission::unlinkBulk($permissions);
```

### Revoke All User Permissions

```php
$permissions = [
    new PermissionData(userId: 5, deviceId: 10),
    new PermissionData(userId: 5, groupId: 2),
    new PermissionData(userId: 5, geofenceId: 3),
    new PermissionData(userId: 5, notificationId: 7),
];

Permission::unlinkBulk($permissions);
```

### Remove Multiple Devices from a Geofence

```php
$deviceIds = [10, 11, 12];
$permissions = array_map(
    fn ($deviceId) => new PermissionData(deviceId: $deviceId, geofenceId: 3),
    $deviceIds
);

Permission::unlinkBulk($permissions);
```

## Important Notes

- Each `PermissionData` in the array must have exactly **2 parameters**
- The parameters must match the exact relationships you want to remove
- If a permission doesn't exist, it may be silently ignored
- Bulk operations are more efficient than individual unlink calls for large datasets
- Standard users can only remove their own permissions

## Related Operations

- [Link Permission](./link) - Link a single permission
- [Unlink Permission](./unlink) - Remove a single permission
- [Link Permissions (Bulk)](./link-bulk) - Link multiple permissions at once

## Important Links

- [Traccar API: Permissions](https://www.traccar.org/api-reference/#tag/Permissions)
- [PermissionData DTO reference](./../reference/dto/permission-data)
