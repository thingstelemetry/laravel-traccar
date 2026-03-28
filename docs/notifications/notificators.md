# Notification Notificators

Retrieve a list of available notificator types.

```php
use ThingsTelemetry\Traccar\Facades\Notification;

$notificators = Notification::notificators();
```

## Parameters

| Parameter      | Type   | Description                                                                 |
|----------------|--------|-----------------------------------------------------------------------------|
| `announcement` | `bool` | Optional. Filter notificators suitable for announcements (excludes web/sms). |

## Usage

### Get all notificators

```php
$notificators = Notification::notificators();
```

### Get announcement-only notificators

```php
$notificators = Notification::notificators(announcement: true);
```

## Response

Returns a `Collection` of `NotificationTypeData` objects.

```php
foreach ($notificators as $notificator) {
    echo $notificator->type; // e.g., "mail", "sms", "telegram"
}
```
