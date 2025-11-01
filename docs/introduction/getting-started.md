# Getting Started

**Things Telemetry Laravel Traccar** is a Laravel specific composer package that simplifies integration with the Traccar GPS tracking platform. It provides an elegant, expressive API to interact with Traccar’s REST endpoints.


## Why This Package?

- 🚀 Integrate Fast – Quick setup with your Traccar API key.
- ✅ Full API Coverage – Access all Traccar endpoints from Laravel.
- 🧑🏾‍💻 Built for Developers – DTOs, consistent error handling, and smooth setup.
- 🧭 Documented & Tested – Clear docs and robust test coverage.
- 🔄 Real-Time Sync – Fetch and sync devices, positions, and events easily.
- 🔐 Secure Authentication – Token-based or credential-based API access.
- ⚙️ Configurable Endpoints – Manage URLs and API keys via .env.
- 🧩 Extendable Architecture – Override or extend core functionality.
- 🕵🏾‍♂️ Detailed Logging – Track API requests, responses, and errors.
- 🧱 Fluent API Design – Chainable, expressive methods like native Laravel syntax.
- 🧰 Helper Commands – Artisan tools for quick testing and syncing.
- 📦 Production Ready – Reliable and scalable for enterprise use.

## Requirements

| Version | PHP    | Composer | Laravel |
|---------|--------|----------|---------|
| 1.x     | >= 8.4 | Required | >= 11.x |

> [!IMPORTANT]
> This package supports Laravel package auto-discovery - no need to register the service provider.

## Installation

You can install the package via Composer

```
composer require thingstelemetry/traccar
```

## Environment variables
- `TRACCAR_API_KEY` – Your Traccar API token
- `TRACCAR_BASE_URL` – Base API URL (default `https://demo.traccar.org/api`)

```dotenv
TRACCAR_API_KEY=your-api-key
TRACCAR_BASE_URL=https://your-traccar-host/api
```

## Configuration

You can publish the `traccar.php` configuration by running the following command:

```bash
php artisan vendor:publish --tag=config --provider="ThingsTelemetry\Traccar\TraccarServiceProvider"
```

<details>
  <summary><strong>Content of the traccar</strong></summary>

  ```php
    return [
        /*
        |--------------------------------------------------------------------------
        | Traccar Base URL
        |--------------------------------------------------------------------------
        | The base URL of your Traccar server’s API endpoint.
        | Example: https://your-traccar-server.com/api
        */
        'base_url' => env(key: 'TRACCAR_BASE_URL'),
    
        /*
         |--------------------------------------------------------------------------
         | Traccar API Key
         |--------------------------------------------------------------------------
         | The API key used to authenticate requests to the Traccar server.
         | You can obtain this from your Traccar server administrator or
         | configuration settings.
         */
        'api_key' => env(key: 'TRACCAR_API_KEY'),
    ];

  ```
</details>


## Usage

```php
use ThingsTelemetry\Traccar\Facades\Server;

// returns ThingsTelemetry\Traccar\Dto\ServerData
$info = Server::getInformation(); 


$version = $info->version; // 6.10
$mapProvider = $info->map->label(); // Google Satellite
$speedUnit = $info->attributes->speedUnit->value; // kmh
$speedUnit = $info->attributes->speedUnit->label(); // Kilometers per Hour (km/h)
$timezone = $info->attributes->timezone; // UTC
$others = $info->attributes->others; // ['otherKey' => 'otherValue']
```

> [!IMPORTANT]
> All responses are DTOs, so you can access their properties directly.
> IDE autocompletion is available for all DTOs.