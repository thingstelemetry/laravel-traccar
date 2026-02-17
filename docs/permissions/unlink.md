# Unlink Permission

Remove a permission relationship between two objects.

## Usage

Use the `ThingsTelemetry\Traccar\Facades\Permission::unlink()` method to remove a permission relationship between two objects.

```php
use ThingsTelemetry\Traccar\Facades\Permission;
use ThingsTelemetry\Traccar\Dto\PermissionData;

$permission = new PermissionData(
    userId: 5,
    deviceId: 10
);

$result = Permission::unlink($permission);

if ($result->status->value === 'success') {
    echo "Permission unlinked successfully";
}
```

## Examples

### Remove User's Access to Device

```php
use ThingsTelemetry\Traccar\Facades\Permission;
use ThingsTelemetry\Traccar\Dto\PermissionData;

$permission = new PermissionData(userId: 5, deviceId: 10);
Permission::unlink($permission);
```

### Remove User's Access to Group

```php
$permission = new PermissionData(userId: 5, groupId: 2);
Permission::unlink($permission);
```

### Remove Device's Geofence Association

```php
$permission = new PermissionData(deviceId: 10, geofenceId: 3);
Permission::unlink($permission);
```

### Remove User Management Permission

```php
$permission = new PermissionData(userId: 5, managedUserId: 8);
Permission::unlink($permission);
```

## Error Handling

```php
use ThingsTelemetry\Traccar\Facades\Permission;
use ThingsTelemetry\Traccar\Dto\PermissionData;
use Saloon\Exceptions\Request\RequestException;

try {
    $permission = new PermissionData(userId: 5, deviceId: 10);
    $result = Permission::unlink($permission);
} catch (InvalidArgumentException $e) {
    // Invalid permission structure - must have exactly 2 properties
} catch (RequestException $e) {
    $status = $e->getResponse()->status();
    
    match ($status) {
        400 => // Bad Request - invalid permission parameters,
        403 => // Forbidden - insufficient permissions,
        404 => // Not Found - permission doesn't exist,
        default => // Handle other errors
    };
}
```

## Important Notes

- Exactly **2 parameters** must be provided in the `PermissionData` object
- The parameters must match the exact relationship you want to remove
- Standard users can only remove their own permissions
- If the permission doesn't exist, the operation may still return success

## Related Operations

- [Link Permission](./link) - Create a permission link
- [Link Permissions (Bulk)](./link-bulk) - Link multiple permissions at once
- [Unlink Permissions (Bulk)](./unlink-bulk) - Remove multiple permissions at once

## Important Links

- [Traccar API: Permissions](https://www.traccar.org/api-reference/#tag/Permissions)
- [PermissionData DTO reference](./../reference/dto/permission-data)
