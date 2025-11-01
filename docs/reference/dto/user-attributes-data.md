# User Attributes Data DTO Reference

The `TrackTelemetry\Traccar\Dto\UserAttributesData` is a generic attribute bag for user-specific settings returned by Traccar.

```php
$attrs = $user->attributes; // UserAttributesData
$raw = $attrs->toArray();   // array<string, mixed>
```

> [!NOTE]
> Traccar user attributes is pending full implementation.