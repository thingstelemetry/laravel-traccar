# OIDC User Info Data DTO Reference

The `ThingsTelemetry\Traccar\Dto\OidcUserInfoData` represents the user information returned by the OIDC userinfo endpoint.

## Properties

| Property | Type | Description |
|----------|------|-------------|
| `sub` | `string` | The unique user identifier. |
| `name` | `string` | The user's display name. |
| `email` | `string` | The user's email address. |

## `sub` → `string`
The subject identifier for the user.

```php
$userInfo->sub; // "1"
```

## `name` → `string`
The display name of the user.

```php
$userInfo->name; // "Admin"
```

## `email` → `string`
The email address of the user.

```php
$userInfo->email; // "admin@example.com"
```
