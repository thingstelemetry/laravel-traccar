# Get Server Information

Get general information about your Traccar server instance. This includes feature flags (e.g., whether registration is enabled), default map settings (map provider, center, zoom), version details, and storage space metrics. Use this endpoint to adapt your client UI/UX and behavior based on the server configuration.

## How to use

You can access the endpoint through the provided Laravel facade. The request returns a ServerData DTO for convenient, typed access to fields.

```php
use TrackTelemetry\Traccar\Facades\Server;

// returns TrackTelemetry\Traccar\Dto\ServerData
$info = Server::getInformation(); 

$version = $info->version; // 6.10
$mapProvider = $info->map->label(); // Google Satellite
$speedUnit = $info->attributes->speedUnit->value; // kmh
$speedUnit = $info->attributes->speedUnit->label(); // Kilometers per Hour (km/h)
$timezone = $info->attributes->timezone; // UTC
$others = $info->attributes->others; // ['otherKey' => 'otherValue']
```

The test suite includes a feature test that mocks this request to ensure it returns a ServerData DTO.

> [!IMPORTANT]
> Some fields may be null or omitted depending on server configuration; the DTO provides default values for certain optional fields.

## Response reference
The response is mapped to TrackTelemetry\Traccar\Dto\ServerData with the following fields:

| Field              | Type                  | Description                                                                                           |
|--------------------|-----------------------|-------------------------------------------------------------------------------------------------------|
| `id`               | integer               | Server entity identifier.                                                                             |
| `attributes`       | ServerAttributes DTO  | Typed server attributes and preferences. Includes units and UI flags. See below.                      |
| `registration`     | boolean               | Whether new user registration is enabled.                                                             |
| `readonly`         | boolean               | Whether the server is in read-only mode for configuration changes.                                    |
| `deviceReadonly`   | boolean               | Whether devices are read-only (cannot be modified by users).                                          |
| `map`              | Map enum              | Default map provider (enum). Use ->value for API key (e.g., 'osm') or ->label() for display.          |
| `bingKey`          | string or null        | API key for Bing Maps when Bing is used.                                                              |
| `mapUrl`           | string or null        | Custom map tiles base URL, if configured.                                                             |
| `overlayUrl`       | string or null        | Optional overlay tiles URL.                                                                           |
| `latitude`         | number                | Default map center latitude.                                                                          |
| `longitude`        | number                | Default map center longitude.                                                                         |
| `zoom`             | integer               | Default map zoom level.                                                                               |
| `forceSettings`    | boolean               | If true, forces clients to use server-provided settings.                                              |
| `coordinateFormat` | CoordinateFormat enum | Preferred coordinate display format (enum). Use ->value or ->label() for display.                     |
| `limitCommands`    | boolean               | If true, limits command execution based on permissions/policies.                                      |
| `disableReports`   | boolean               | If true, reporting features are disabled.                                                             |
| `fixedEmail`       | boolean               | If true, email is fixed and cannot be changed by users.                                               |
| `poiLayer`         | string or null        | Points-of-interest layer URL or identifier, if any.                                                   |
| `announcement`     | string or null        | Optional announcement/broadcast message to show to users.                                             |
| `emailEnabled`     | boolean               | Whether email features (notifications) are enabled.                                                   |
| `geocoderEnabled`  | boolean               | Whether geocoding (reverse geocode addresses) is enabled.                                             |
| `textEnabled`      | boolean               | Whether text/SMS features are enabled.                                                                |
| `storageSpace`     | `array<number>`       | Storage metrics array. Typically represents free/total and other disk statistics reported by Traccar. |
| `newServer`        | boolean               | True if the server is in a "new"/first-run state.                                                     |
| `openIdEnabled`    | boolean               | Whether OpenID authentication is enabled.                                                             |
| `openIdForce`      | boolean               | If true, OpenID auth is enforced for sign-in.                                                         |
| `version`          | string                | Traccar server version string.                                                                        |

### Typed fields and enums

- Map `TrackTelemetry/Traccar/Enums/Map`
  - Values: 'openFreeMap', 'locationIqStreets', 'locationIqDark', 'osm', 'openTopoMap', 'carto', 'googleRoad', 'googleSatellite', 'googleHybrid', 'autoNavi', 'ordnanceSurvey'
  - Defaults to: Map::LOCATION_IQ_STREETS when API value is null/unknown
  - Tips: Use ->value for the raw key (e.g., 'osm') or ->label() for a human-friendly name

- CoordinateFormat `TrackTelemetry/Traccar/Enums/CoordinateFormat`
  - Values: 'dd' (Decimal Degrees), 'ddm' (Degrees Decimal Minutes), 'dms' (Degrees Minutes Seconds)
  - Default: CoordinateFormat::DD

- ServerAttributes `TrackTelemetry/Traccar/Dto/ServerAttributes`
  - Contains optional UI and preference fields such as language, map settings, and units
  - Units are strongly typed enums with sensible defaults if missing:
    - `speedUnit`: SpeedUnit ('kn', 'kmh', 'mph') — default SpeedUnit::KNOTS
    - `distanceUnit`: DistanceUnit ('km', 'mi', 'nmi') — default DistanceUnit::KILOMETERS
    - `altitudeUnit`: AltitudeUnit ('m', 'ft') — default AltitudeUnit::METERS
    - `volumeUnit`: VolumeUnit ('l', 'gal') — default VolumeUnit::LITERS
    - `timezone`: string — default 'UTC'
  - Any unknown/extra keys from the API are preserved in attributes->others for forward compatibility

> [!IMPORTANT]
> For enum-backed fields, the DTO safely falls back to a sensible default when the API provides null or an unrecognized value. This allows you to rely on consistent types across your application.


### Related
- Source: `src/Requests/GetServerInformation.php` (endpoint definition)
- DTO: `src/Dto/ServerData.php` (response mapping)
- Facade entrypoint: `src/Endpoints/Server.php` and `src/Facades/Server.php`
