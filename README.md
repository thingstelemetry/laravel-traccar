# TrackTelemetry Traccar PHP SDK

A lightweight PHP and Laravel package that provides a seamless way to interact with the Traccar API.

- Namespace: `TrackTelemetry\Traccar`
- Laravel-ready via auto-discovery (Service Provider included)
- Vanilla PHP friendly

## Requirements
- PHP >= 8.0
- Composer

## Installation

Install via Composer:

```
composer require tracktelemetry/traccar
```

## Configuration

### Environment variables
- `TRACCAR_API_KEY` – Your Traccar API token
- `TRACCAR_BASE_URL` – Base API URL (default `https://demo.traccar.org/api`)

### PHP (non-Laravel)
You can load the provided config file directly or pass values to the client:

```

### Laravel
This package supports Laravel package auto-discovery.

1. Publish the configuration (optional):
   ```bash
   php artisan vendor:publish --tag=config --provider="TrackTelemetry\\Traccar\\TraccarServiceProvider"
   ```

2. Set your environment variables in `.env`:
   ```dotenv
   TRACCAR_API_KEY=your-api-key
   TRACCAR_BASE_URL=https://your-traccar-host/api
   ```

3. Resolve the client from the container or use type-hinting:
   ```php
   use TrackTelemetry\Traccar\TraccarClient;

   // Via helper
   $client = app(TraccarClient::class);
   $devices = $client->get('devices');

   // Or via constructor injection in your classes/controllers
   public function __construct(private TraccarClient $traccar) {}
   ```

## Usage

// TODO

## Tests

Run PHPUnit:

```
vendor/bin/pest
```

## License

MIT
