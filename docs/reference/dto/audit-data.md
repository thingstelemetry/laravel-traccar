# Audit Data DTO Reference

The `ThingsTelemetry\Traccar\Dto\AuditData` represents a Traccar audit log entry. Audit logs describe actions performed by users (e.g., login, device update, etc.).

```php
use ThingsTelemetry\Traccar\Facades\Audit;

$auditLogs = Audit::get(); // Collection<int, AuditData>
```

## Properties

| Property | Type | Description |
|----------|------|-------------|
| `id` | `int` | Unique audit record identifier. |
| `userId` | `int` | Identifier of the user who performed the action. |
| `userEmail` | `string?` | Email of the user who performed the action. |
| `type` | `string` | Type of the action performed. |
| `actionTime` | `CarbonImmutable?` | Time the action occurred. |
| `attributes` | `array` | Action-specific attributes payload. |

## `id` → `integer`
Unique audit record identifier in Traccar.

```php
$log->id; // 1
```

## `userId` → `integer`
Identifier of the user who performed the action.

```php
$log->userId; // 10
```

## `userEmail` → `string|null`
Email of the user who performed the action.

```php
$log->userEmail; // "admin@example.com"
```

## `type` → `string`
Type of the action performed (e.g., `"login"`, `"deviceUpdate"`).

```php
$log->type; // "login"
```

## `actionTime` → `CarbonImmutable|null`
Time the action occurred, parsed from ISO 8601.

```php
$log->actionTime->toIso8601String(); // "2025-01-01T12:00:00Z"
```

## `attributes` → `array<string, mixed>`
Action-specific attributes payload returned by Traccar.

```php
$log->attributes; // [ 'deviceId' => 5, ... ]
```
