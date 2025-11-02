# Get Server Information

Get general about your Traccar server instance into your laravel application.

## Request

Use the `ThingsTelemetry\Traccar\Facades\Server::getInformation()` method to get information about your Traccar server instance.

```php

$info = \ThingsTelemetry\Traccar\Facades\Server::getInformation(); 
```

## Results

The response is an instance of `ThingsTelemetry\Traccar\Dto\ServerData` DTO class

```php
$version = $info->version; // 6.10
$mapProvider = $info->map->label(); // Google Satellite
$speedUnit = $info->attributes->speedUnit->value; // kmh
$speedUnit = $info->attributes->speedUnit->label(); // Kilometers per Hour (km/h)
$timezone = $info->attributes->timezone; // UTC
```

### Key Results Items

While most fields are cast into a string or ints, some are cast into a DTO/Service class.

- **`ServerAttributesData`** → [`ThingsTelemetry\Traccar\Dto\ServerAttributesData`](./../reference/dto/server-data)  
  *Data Transfer Object for Traccar server attributes.*

- **`map`** → [`ThingsTelemetry\Traccar\Enums\Map`](./../reference/enums/map)  
  *Enum representing available map providers.*

- **`coordinateFormat`** → [`ThingsTelemetry\Traccar\Enums\CoordinateFormat`](./../reference/enums/coordinate-format)  
  *Enum defining how coordinates are displayed or formatted.*

- **`storage`** → [`ThingsTelemetry\Traccar\Support\StorageInfo`](./../reference/enums/map)  
  *Service class representing storage information (total, free, etc.).*
> [!IMPORTANT]
> Refer to the [ServerData DTO documentation](./../reference/dto/server-data) for more details on the DTO structure.

## Important Links
- [Traccar Fetch Server information Documentation](https://www.traccar.org/api-reference/#tag/Server/paths/~1server/get)
- [ServerData DTO documentation](./../reference/dto/server-data)
