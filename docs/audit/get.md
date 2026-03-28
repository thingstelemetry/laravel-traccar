# Retrieve Audit Logs

Fetch audit logs from your Traccar server. Only administrators can access this endpoint.

## Request

Use the `ThingsTelemetry\Traccar\Facades\Audit::get(?CarbonImmutable $from = null, ?CarbonImmutable $to = null)` method to retrieve audit logs.

```php
use ThingsTelemetry\Traccar\Facades\Audit;
use Carbon\CarbonImmutable;

$from = CarbonImmutable::parse('2025-01-01');
$to = CarbonImmutable::parse('2025-01-02');

$auditLogs = Audit::get(from: $from, to: $to); // Illuminate\Support\Collection<int, ThingsTelemetry\Traccar\Dto\AuditData>
```

## Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `from` | `?CarbonImmutable` | Start date for audit logs (optional). |
| `to` | `?CarbonImmutable` | End date for audit logs (optional). |

## Result

The response is a `Collection` of `ThingsTelemetry\Traccar\Dto\AuditData` instances.

```php
foreach ($auditLogs as $log) {
    $id         = $log->id;
    $userId     = $log->userId;
    $userEmail  = $log->userEmail;
    $type       = $log->type;
    $actionTime = $log->actionTime; // CarbonImmutable
    $attributes = $log->attributes; // array
}
```

## Important Links
- [Traccar: Audit Logs API](https://www.traccar.org/api-reference/)
- [AuditData DTO reference](./../reference/dto/audit-data)
