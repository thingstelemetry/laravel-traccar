# ServerData Dto Reference


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
