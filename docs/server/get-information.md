# Get Server Information

Get general about your Traccar server instance into your laravel application.

## Request

Use the `TrackTelemetry\Traccar\Facades\Server` facade to get information about your Traccar server instance.

```php
use TrackTelemetry\Traccar\Facades\Server;

$info = Server::getInformation(); 
```

## Results

The response is a instance of ` TrackTelemetry\Traccar\Dto\ServerData` DTO class

```php
$version = $info->version; // 6.10
$mapProvider = $info->map->label(); // Google Satellite
$speedUnit = $info->attributes->speedUnit->value; // kmh
$speedUnit = $info->attributes->speedUnit->label(); // Kilometers per Hour (km/h)
$timezone = $info->attributes->timezone; // UTC
$others = $info->attributes->others; // ['otherKey' => 'otherValue']
```

### Key Results Items

While most field are casted into a string or ints, some are casted into a DTO/Service class.

- **`ServerAttributesData`** → [`TrackTelemetry\Traccar\Dto\ServerAttributesData`](./#todo)  
  *Data Transfer Object for Traccar server attributes.*

- **`map`** → [`TrackTelemetry\Traccar\Enums\Map`](./../reference/enums/map)  
  *Enum representing available map providers.*

- **`coordinateFormat`** → [`TrackTelemetry\Traccar\Enums\CoordinateFormat`](./#todo)  
  *Enum defining how coordinates are displayed or formatted.*

- **`storage`** → [`TrackTelemetry\Traccar\Support\StorageInfo`](./#todo)  
  *Service class representing storage information (total, free, etc.).*
> [!IMPORTANT]
> Refer to the [ServerData DTO documentation](./../reference/dto/server-data) for more details on the DTO structure.

## Important Links
- [Traccar Fetch Server information Documentation](https://www.traccar.org/api-reference/#tag/Server/paths/~1server/get)
- [ServerData DTO documentation](./../reference/dto/server-data)
