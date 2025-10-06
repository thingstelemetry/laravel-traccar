---
title: Get Server Information
description: Retrieve general Traccar server information, capabilities, and defaults.
---

## Overview
The Get Server Information endpoint returns general information about your Traccar server instance. This includes feature flags (e.g., whether registration is enabled), default map settings (map provider, center, zoom), version details, and storage space metrics. Use this endpoint to adapt your client UI/UX and behavior based on the server configuration.

- Method: GET
- Path: /server
- Auth: Uses the Traccar credentials configured for this package (see configuration). Requests are performed via the package connector.

## How to use
You can access the endpoint through the provided Laravel facade. The request returns a ServerData DTO for convenient, typed access to fields.

- Using the facade:

```php
use TrackTelemetry\Traccar\Facades\Server;

$info = Server::getInformation(); // returns TrackTelemetry\Traccar\Dto\ServerData

// Example access
$version = $info->version;
$registrationEnabled = $info->registration;
$mapProvider = $info->map; // e.g. "osm"
```

- Low-level request (if you are working with the connector directly):

```php
use TrackTelemetry\Traccar\TraccarConnector;
use TrackTelemetry\Traccar\Requests\GetServerInformation;

$connector = app(TraccarConnector::class);
$response = $connector->send(new GetServerInformation());
$info = $response->dtoOrFail(); // ServerData
```

The test suite includes a feature test that mocks this request to ensure it returns a ServerData DTO.

## Example response
Below is an example response structure you can expect from the Traccar API. Values may vary depending on server configuration.

```json
{
  "id": 1,
  "attributes": {},
  "registration": false,
  "readonly": false,
  "deviceReadonly": false,
  "map": null,
  "bingKey": null,
  "mapUrl": null,
  "overlayUrl": null,
  "latitude": 0.0,
  "longitude": 0.0,
  "zoom": 0,
  "forceSettings": false,
  "coordinateFormat": null,
  "limitCommands": false,
  "disableReports": false,
  "fixedEmail": false,
  "poiLayer": null,
  "announcement": null,
  "emailEnabled": true,
  "geocoderEnabled": true,
  "textEnabled": false,
  "storageSpace": [
    40778186752,
    245107195904,
    38552756224,
    45598019584,
    38552756224,
    45598019584,
    38552756224,
    45598019584,
    38552756224,
    45598019584,
    38552756224,
    45598019584,
    1558183936,
    1558183936,
    1558421504,
    1558421504
  ],
  "newServer": false,
  "openIdEnabled": false,
  "openIdForce": false,
  "version": "6.10.0"
}
```

Note: Some fields may be null or omitted depending on server configuration; the DTO provides default values for certain optional fields.

## Response reference
The response is mapped to TrackTelemetry\Traccar\Dto\ServerData with the following fields:

| Field            | Type           | Description                                                                                           |
|------------------|----------------|-------------------------------------------------------------------------------------------------------|
| id               | integer        | Server entity identifier.                                                                             |
| attributes       | object/map     | Arbitrary key-value attributes applied to the server.                                                 |
| registration     | boolean        | Whether new user registration is enabled.                                                             |
| readonly         | boolean        | Whether the server is in read-only mode for configuration changes.                                    |
| deviceReadonly   | boolean        | Whether devices are read-only (cannot be modified by users).                                          |
| map              | string or null | Default map provider key (e.g., "osm", "bing"), if configured.                                        |
| bingKey          | string or null | API key for Bing Maps when Bing is used.                                                              |
| mapUrl           | string or null | Custom map tiles base URL, if configured.                                                             |
| overlayUrl       | string or null | Optional overlay tiles URL.                                                                           |
| latitude         | number         | Default map center latitude.                                                                          |
| longitude        | number         | Default map center longitude.                                                                         |
| zoom             | integer        | Default map zoom level.                                                                               |
| forceSettings    | boolean        | If true, forces clients to use server-provided settings.                                              |
| coordinateFormat | string or null | Preferred coordinate display format, if provided.                                                     |
| limitCommands    | boolean        | If true, limits command execution based on permissions/policies.                                      |
| disableReports   | boolean        | If true, reporting features are disabled.                                                             |
| fixedEmail       | boolean        | If true, email is fixed and cannot be changed by users.                                               |
| poiLayer         | string or null | Points-of-interest layer URL or identifier, if any.                                                   |
| announcement     | string or null | Optional announcement/broadcast message to show to users.                                             |
| emailEnabled     | boolean        | Whether email features (notifications) are enabled.                                                   |
| geocoderEnabled  | boolean        | Whether geocoding (reverse geocode addresses) is enabled.                                             |
| textEnabled      | boolean        | Whether text/SMS features are enabled.                                                                |
| storageSpace     | array<number>  | Storage metrics array. Typically represents free/total and other disk statistics reported by Traccar. |
| newServer        | boolean        | True if the server is in a "new"/first-run state.                                                     |
| openIdEnabled    | boolean        | Whether OpenID authentication is enabled.                                                             |
| openIdForce      | boolean        | If true, OpenID auth is enforced for sign-in.                                                         |
| version          | string         | Traccar server version string.                                                                        |

### Error handling
- Authentication or connectivity issues will result in an exception from the underlying connector. Use try/catch when calling Server::getInformation() if you need to handle failures gracefully.

### Related
- Source: src/Requests/GetServerInformation.php (endpoint definition)
- DTO: src/Dto/ServerData.php (response mapping)
- Facade entrypoint: src/Endpoints/Server.php and src/Facades/Server.php
