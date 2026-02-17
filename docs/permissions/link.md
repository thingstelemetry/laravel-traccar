# Link Permission

Link one object to another object (create a permission relationship).

## Usage

Use the `ThingsTelemetry\Traccar\Facades\Permission::link()` method to create a permission relationship between two objects.

```php
use ThingsTelemetry\Traccar\Facades\Permission;
use ThingsTelemetry\Traccar\Dto\PermissionData;

$permission = new PermissionData(
    userId: 5,
    deviceId: 10
);

$result = Permission::link($permission);

if ($result->status->value === 'success') {
    echo "Permission linked successfully";
}
```

## Common Permission Types

### User Permissions

```php
use ThingsTelemetry\Traccar\Dto\PermissionData;

// User → Device
new PermissionData(userId: 5, deviceId: 10)

// User → Group
new PermissionData(userId: 5, groupId: 2)

// User → Geofence
new PermissionData(userId: 5, geofenceId: 3)

// User → Notification
new PermissionData(userId: 5, notificationId: 7)

// User → Calendar
new PermissionData(userId: 5, calendarId: 1)

// User → Computed Attribute
new PermissionData(userId: 5, attributeId: 4)

// User → Driver
new PermissionData(userId: 5, driverId: 6)

// User manages another User
new PermissionData(userId: 5, managedUserId: 8)

// User → Command
new PermissionData(userId: 5, commandId: 9)
```

### Device/Group Permissions

```php
// Device → Geofence
new PermissionData(deviceId: 10, geofenceId: 3)

// Device → Command
new PermissionData(deviceId: 10, commandId: 8)

// Device → Driver
new PermissionData(deviceId: 10, driverId: 5)

// Group → Geofence
new PermissionData(groupId: 2, geofenceId: 3)

// Group → Notification
new PermissionData(groupId: 2, notificationId: 7)
```

## Error Handling

```php
use ThingsTelemetry\Traccar\Facades\Permission;
use ThingsTelemetry\Traccar\Dto\PermissionData;
use Saloon\Exceptions\Request\RequestException;

try {
    $permission = new PermissionData(userId: 5, deviceId: 10);
    $result = Permission::link($permission);
} catch (InvalidArgumentException $e) {
    // Invalid permission structure - must have exactly 2 properties
} catch (RequestException $e) {
    $status = $e->getResponse()->status();
    
    match ($status) {
        400 => // Bad Request - invalid permission parameters,
        403 => // Forbidden - insufficient permissions,
        404 => // Not Found - one of the objects doesn't exist,
        default => // Handle other errors
    };
}
```

## Important Notes

- Exactly **2 parameters** must be provided in the `PermissionData` object
- Order matters: First parameter is the subject, second is the object
- Standard users can only manage their own permissions
- Admins and managers have broader permission management capabilities

## Related Operations

- [Unlink Permission](./unlink) - Remove a permission link
- [Link Permissions (Bulk)](./link-bulk) - Link multiple permissions at once
- [Unlink Permissions (Bulk)](./unlink-bulk) - Remove multiple permissions at once

## Important Links

- [Traccar API: Permissions](https://www.traccar.org/api-reference/#tag/Permissions)
- [PermissionData DTO reference](./../reference/dto/permission-data)
