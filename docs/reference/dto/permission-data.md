# Permission Data DTO Reference

The `ThingsTelemetry\Traccar\Dto\PermissionData` represents a permission relationship between two Traccar entities. It is used to link or unlink objects such as users, devices, groups, geofences, and more.

```php
use ThingsTelemetry\Traccar\Dto\PermissionData;

// User to Device permission
$permission = new PermissionData(userId: 5, deviceId: 10);
```

## Properties

| Property | Type | Description |
|----------|------|-------------|
| `userId` | `?int` | User identifier |
| `deviceId` | `?int` | Device identifier |
| `groupId` | `?int` | Group identifier |
| `geofenceId` | `?int` | Geofence identifier |
| `notificationId` | `?int` | Notification identifier |
| `calendarId` | `?int` | Calendar identifier |
| `attributeId` | `?int` | Computed attribute identifier |
| `driverId` | `?int` | Driver identifier |
| `managedUserId` | `?int` | Managed user identifier |
| `commandId` | `?int` | Command identifier |
| `maintenanceId` | `?int` | Maintenance identifier |

## Rules

- Exactly **2 parameters** must be provided
- **Order matters**: First parameter is the subject, second is the object

### Valid First Parameters (Subject)

| Parameter | Description |
|-----------|-------------|
| `userId` | User identifier |
| `deviceId` | Device identifier |
| `groupId` | Group identifier |

### Valid Second Parameters (Object)

| When First Parameter is | Valid Second Parameters |
|-------------------------|-------------------------|
| `userId` | `deviceId`, `groupId`, `geofenceId`, `notificationId`, `calendarId`, `attributeId`, `driverId`, `managedUserId`, `commandId`, `maintenanceId` |
| `deviceId` or `groupId` | `geofenceId`, `notificationId`, `attributeId`, `driverId`, `commandId`, `maintenanceId` |

## Validation

The `validate()` method throws an `InvalidArgumentException` if the permission does not have exactly 2 properties set:

```php
$permission = new PermissionData(userId: 1);
$permission->validate(); // Throws InvalidArgumentException
```

## Usage Examples

### User Permissions

```php
use ThingsTelemetry\Traccar\Dto\PermissionData;

// User to Device
$permission = new PermissionData(userId: 5, deviceId: 10);

// User to Group
$permission = new PermissionData(userId: 5, groupId: 2);

// User to Geofence
$permission = new PermissionData(userId: 5, geofenceId: 3);

// User to Notification
$permission = new PermissionData(userId: 5, notificationId: 7);

// User to Calendar
$permission = new PermissionData(userId: 5, calendarId: 1);

// User to Computed Attribute
$permission = new PermissionData(userId: 5, attributeId: 4);

// User to Driver
$permission = new PermissionData(userId: 5, driverId: 6);

// User manages another User
$permission = new PermissionData(userId: 5, managedUserId: 8);

// User to Command
$permission = new PermissionData(userId: 5, commandId: 9);

// User to Maintenance
$permission = new PermissionData(userId: 5, maintenanceId: 10);
```

### Device/Group Permissions

```php
// Device to Geofence
$permission = new PermissionData(deviceId: 10, geofenceId: 3);

// Device to Command
$permission = new PermissionData(deviceId: 10, commandId: 8);

// Device to Driver
$permission = new PermissionData(deviceId: 10, driverId: 5);

// Group to Geofence
$permission = new PermissionData(groupId: 2, geofenceId: 3);

// Group to Notification
$permission = new PermissionData(groupId: 2, notificationId: 7);

// Group to Command
$permission = new PermissionData(groupId: 2, commandId: 9);

// Device to Maintenance
$permission = new PermissionData(deviceId: 10, maintenanceId: 5);
```

## Serialization

### `fromArray(array $data): self`

Create a DTO from an array:

```php
$permission = PermissionData::fromArray([
    'userId' => 5,
    'deviceId' => 10,
]);
```

### `toArray(): array`

Convert the DTO to an array (null values are excluded):

```php
$permission = new PermissionData(userId: 5, deviceId: 10);

$permission->toArray();
// ['userId' => 5, 'deviceId' => 10]
```

## Complete Example

```php
use ThingsTelemetry\Traccar\Facades\Permission;
use ThingsTelemetry\Traccar\Dto\PermissionData;

// Grant user access to multiple devices
$permissions = [
    new PermissionData(userId: 5, deviceId: 10),
    new PermissionData(userId: 5, deviceId: 11),
    new PermissionData(userId: 5, deviceId: 12),
];

$result = Permission::linkBulk($permissions);

// Revoke access
$revoke = new PermissionData(userId: 5, deviceId: 10);
Permission::unlink($revoke);
```

## Related Operations

- [Link Permission](./../../permissions/link) - Link a single permission
- [Unlink Permission](./../../permissions/unlink) - Remove a single permission
- [Link Permissions (Bulk)](./../../permissions/link-bulk) - Link multiple permissions
- [Unlink Permissions (Bulk)](./../../permissions/unlink-bulk) - Remove multiple permissions
