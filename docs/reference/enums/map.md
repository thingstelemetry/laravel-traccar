# Map Enum Reference

The `TrackTelemetry\Traccar\Enums\Map` enum defines the available map providers supported by the Traccar integration. It provides a clear, typed way to reference map layers used for visualization within the system.

## Example

```php
use TrackTelemetry\Traccar\Enums\Map;

$map = Map::GOOGLE_SATELLITE;
$map->value; // googleSatellite
$map->name; // GOOGLE_SATELLITE
$map->label(); // Google Satellite
```

## Enum Cases

| Case                  | Value                 | Description                                                      |
|-----------------------|-----------------------|------------------------------------------------------------------|
| `OPEN_FREE_MAP`       | `'openFreeMap'`       | Open Free Map – lightweight and open map provider.               |
| `LOCATION_IQ_STREETS` | `'locationIqStreets'` | LocationIQ Streets – default provider with detailed street data. |
| `LOCATION_IQ_DARK`    | `'locationIqDark'`    | LocationIQ Dark – dark theme version of LocationIQ maps.         |
| `OSM`                 | `'osm'`               | OpenStreetMap – community-driven open map platform.              |
| `OPEN_TOPO_MAP`       | `'openTopoMap'`       | OpenTopoMap – topographic map variant based on OSM data.         |
| `CARTO`               | `'carto'`             | Carto Basemaps – stylized maps suitable for analytics.           |
| `GOOGLE_ROAD`         | `'googleRoad'`        | Google Road – classic Google Maps road view.                     |
| `GOOGLE_SATELLITE`    | `'googleSatellite'`   | Google Satellite – satellite imagery view.                       |
| `GOOGLE_HYBRID`       | `'googleHybrid'`      | Google Hybrid – combined satellite and road view.                |
| `AUTO_NAVI`           | `'autoNavi'`          | AutoNavi – navigation-focused Chinese map provider.              |
| `ORDNANCE_SURVEY`     | `'ordnanceSurvey'`    | Ordnance Survey – detailed UK-based mapping service.             |

> [!IMPORTANT]
> The enum values have been derived from the [Traccar source code](https://github.com/traccar/traccar-web/blob/master/src/map/core/useMapStyles.js).

## Methods

### `public static function default(): self`

Returns the default map provider (`LOCATION_IQ_STREETS`).

### `public function label(): string`

Returns a human-readable label for each map provider (e.g., `"Google Satellite"` for `GOOGLE_SATELLITE`).