# User Data DTO Reference

The `ThingsTelemetry\Traccar\Dto\UserData` represents a Traccar user entity.

```php
use ThingsTelemetry\Traccar\Facades\User;

$user = User::get(42); // UserData
```

## Properties

| Property | Type | Description |
|----------|------|-------------|
| `id` | `int` | Unique user identifier. |
| `name` | `string` | User full name. |
| `email` | `string` | User email. |
| `phone` | `string|null` | Contact phone. |
| `readonly` | `bool` | Whether the user is read-only. |
| `administrator` | `bool` | Admin flag. |
| `map` | `Map` | Preferred map provider. |
| `latitude` | `float` | Default map center latitude. |
| `longitude` | `float` | Default map center longitude. |
| `zoom` | `int` | Default map zoom. |
| `password` | `string|null` | Password field. |
| `coordinateFormat` | `CoordinateFormat` | Preferred coordinate format. |
| `disabled` | `bool` | If the user is disabled. |
| `expirationTime` | `CarbonImmutable|null` | Account expiration timestamp. |
| `deviceLimit` | `int` | Assigned limit for devices. |
| `userLimit` | `int` | Assigned limit for sub-users. |
| `deviceReadonly` | `bool` | Device read-only permission flag. |
| `limitCommands` | `bool` | Limit commands permission flag. |
| `fixedEmail` | `bool` | Fixed email permission flag. |
| `poiLayer` | `string|null` | Points-of-interest layer ID. |
| `attributes` | `UserAttributesData` | User attribute bag. |

## `id` → `integer`
Unique user identifier.

## `name` → `string`
User full name.

## `email` → `string`
User email.

## `phone` → `string|null`
Contact phone.

## `readonly` → `boolean`
Whether the user is read-only.

## `administrator` → `boolean`
Admin flag.

## `map` → [`Map`](../enums/map)
Preferred map provider.

## `latitude`, `longitude` → `float`
Default map center coordinates.

## `zoom` → `integer`
Default map zoom.

## `password` → `string|null`
Password field (if returned by API).

## `coordinateFormat` → [`CoordinateFormat`](../enums/coordinate-format)
Preferred coordinate format.

## `disabled` → `boolean`
If the user is disabled.

## `expirationTime` → `CarbonImmutable|null`
Account expiration timestamp if set.

## `deviceLimit`, `userLimit` → `integer`
Assigned limits for devices and sub-users.

## `deviceReadonly`, `limitCommands`, `fixedEmail` → `boolean`
Permission/control flags.

## `poiLayer` → `string|null`
Points-of-interest layer ID or URL.

## `attributes` → [`UserAttributesData`](./user-attributes-data)
User attribute bag.
