# Device Attributes Data Dto Reference

The `ThingsTelemetry\Traccar\Dto\DeviceAttributesData` represents additional, device-specific attributes provided by Traccar. These can control reporting behavior, visuals, thresholds, and forwarding.

```php
use ThingsTelemetry\Traccar\Facades\Device;

// ThingsTelemetry\Traccar\Dto\DeviceAttributesData;
$attributes = Device::getAll()->first()->attributes
```

## `speedLimit` → `float|null`

Maximum speed threshold for the device.
```php
$attributes->speedLimit; // 80.0
```
> [!WARNING]
> The speedLimit value is always stored in knots in Traccar, even if the server is configured to use other units. That's the default units all GPS modules use.
> [Ref 1](https://www.traccar.org/forums/topic/why-is-speed-stored-as-knots/) [Ref 2](https://www.traccar.org/forums/topic/setting-the-speed-limit-and-speed-limit-notifications/#post-7543) [Ref 3](https://www.traccar.org/forums/topic/speed-attribute/#post-27500/)

## `fuelDropThreshold` → `float|null`

Threshold for detecting a fuel drop event.
```php
$attributes->fuelDropThreshold; // 5.0
```

## `fuelIncreaseThreshold` → `float|null`

Threshold for detecting a fuel increase/refueling event.
```php
$attributes->fuelIncreaseThreshold; // 8.5
```

## `reportIgnoreOdometer` → `boolean|null`

If true, odometer value is ignored in reports for this device.
```php
$attributes->reportIgnoreOdometer; // false
```

## `deviceInactivityStart` → `float|null`

Start time (minutes) before considering device inactive.
```php
$attributes->deviceInactivityStart; // 30
```

## `deviceInactivityPeriod` → `float|null`

Length of inactivity period (minutes) after start threshold.
```php
$attributes->deviceInactivityPeriod; // 60
```

## `notificationTokens` → `string|null`

Comma-separated push notification tokens for this device.
```php
$attributes->notificationTokens; // "TOKEN1,TOKEN2"
```

## `commandSender` → `string|null`

Sender identifier used for device commands.
```php
$attributes->commandSender; // "system"
```

## `webReportColor` → `string|null`

Hex or named color used for device reports in the web UI.
```php
$attributes->webReportColor; // "#FF9900"
```

## `devicePassword` → `string|null`

Password for certain device protocols requiring authentication.
```php
$attributes->devicePassword; // "secret"
```

## `deviceImage` → `string|null`

URL or asset path for a custom device image.
```php
$attributes->deviceImage; // "https://example.com/images/device.png"
```

## `processingCopyAttributes` → `string|null`

Comma-separated attribute keys to be copied during processing.
```php
$attributes->processingCopyAttributes; // "ignition,battery"
```

## `decoderTimezone` → `string|null`

Custom timezone for decoding device messages.
```php
$attributes->decoderTimezone; // "UTC"
```

## `forwardUrl` → `string|null`

URL to forward device data to an external system.
```php
$attributes->forwardUrl; // "https://webhook.example.com/traccar"
```

> [!IMPORTANT]
> Null boolean attributes default to `false` when interpreted in most application logic. Validate and coalesce as needed.