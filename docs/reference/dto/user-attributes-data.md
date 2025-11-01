# User Attributes Data DTO Reference

The `TrackTelemetry\\Traccar\\Dto\\UserAttributesData` provides typed access to user-specific attributes supported by Traccar. All fields are optional; booleans default to `false`, numbers and strings default to `null`.

```php
$attrs = $user->attributes; // UserAttributesData
$raw = $attrs->toArray();   // array<string, mixed>
```

## Map and UI
- `language` → `string|null`
- `mapGeofences` → `bool`
- `mapLiveRoutes` → `string|null`
- `mapDirection` → `string|null`
- `mapFollow` → `bool`
- `mapCluster` → `bool`
- `mapOnSelect` → `bool`
- `activeMapStyles` → `string|null`
- `devicePrimary` → `string|null`
- `deviceSecondary` → `string|null`
- `soundEvents` → `string|null`
- `soundAlarms` → `string|null`
- `positionItems` → `string|null`

## Map Providers / API keys
- `googleKey`, `locationIqKey`, `mapboxAccessToken`, `mapTilerKey`, `bingMapsKey`, `openWeatherKey`, `tomTomKey`, `hereKey` → `string|null`

## UI disable flags
- `ui.disableSavedCommands`, `ui.disableGroups`, `ui.disableAttributes`, `ui.disableEvents`, `ui.disableVehicleFeatures`, `ui.disableDrivers`, `ui.disableComputedAttributes`, `ui.disableCalendars`, `ui.disableMaintenance` → `bool`

## Web map tuning
- `web.liveRouteLength` → `int|null`
- `mapLineWidth` → `float|null`
- `mapLineOpacity` → `float|null`
- `web.selectZoom` → `int|null`
- `web.maxZoom` → `int|null`
- `iconScale` → `float|null`
- `navigationAppLink`, `navigationAppTitle` → `string|null`

## Notifications / Integrations
- `telegramChatId`, `pushoverUserKey`, `pushoverDeviceNames` → `string|null`

## SMTP settings
- `mail.smtp.host` → `string|null`
- `mail.smtp.port` → `int|null`
- `mail.smtp.starttls.enable`, `mail.smtp.starttls.required`, `mail.smtp.ssl.enable`, `mail.smtp.auth` → `bool`
- `mail.smtp.ssl.trust`, `mail.smtp.ssl.protocols`, `mail.smtp.from`, `mail.smtp.username`, `mail.smtp.password` → `string|null`

## Other
- `termsAccepted` → `bool`
- `billingLink` → `string|null`

### Example
```php
use TrackTelemetry\\Traccar\\Dto\\UserAttributesData;

$attrs = new UserAttributesData(
    mapGeofences: true,
    webLiveRouteLength: 1000,
    uiDisableGroups: true,
);

$attrs->toArray();
// [
//   'mapGeofences' => true,
//   'web.liveRouteLength' => 1000,
//   'ui.disableGroups' => true,
//   ...
// ]
```
