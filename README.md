# Things Telemetry Traccar PHP SDK

[![Latest Version on Packagist](https://img.shields.io/packagist/v/thingstelemetry/laravel-traccar.svg?style=flat-square)](https://packagist.org/packages/thingstelemetry/laravel-traccar)
![GitHub Actions Test Status](https://img.shields.io/github/actions/workflow/status/thingstelemetry/laravel-traccar/tests.yml?logo=github&label=Tests)
[![Total Downloads](https://img.shields.io/packagist/dt/thingstelemetry/laravel-traccar.svg?style=flat-square)](https://packagist.org/packages/thingstelemetry/laravel-traccar)

![Traccar Screenshot](./docs/images/traccar-home-page.webp)

**Things Telemetry Laravel Traccar** is a Laravel-specific composer package that simplifies integration with the Traccar GPS tracking platform. It provides an elegant, expressive API to interact with Traccar’s REST endpoints.


## Requirements

| Version | PHP          | Laravel |
|---------|--------------|---------|
| 1.x     | 8.4.x, 8.5.x | 13.x    |

## Installation

You can install the package via Composer

```
composer require thingstelemetry/laravel-traccar
```

## Configuration

### Environment variables
- `TRACCAR_API_KEY` – Your Traccar API token
- `TRACCAR_BASE_URL` – Base API URL (default `https://demo.traccar.org/api`)


## Publishing Configuration

You can publish the configuration by running the following command:

```bash
php artisan vendor:publish --tag=config --provider="ThingsTelemetry\Traccar\TraccarServiceProvider"
```

# Usage

Here is a quick example of how to get server information.

```php
use ThingsTelemetry\Traccar\Facades\Server;

// returns ThingsTelemetry\Traccar\Dto\ServerData
$info = Server::get(); 

$version = $info->version; // '6.10'
$speedUnit = $info->attributes->speedUnit->value; // 'kn', 'kmh', or 'mph'
$timezone = $info->attributes->timezone; // e.g. 'UTC'
````

## Full Documentation
The full documentation can be found [on Things Telemetry Website](https://traccar.thingstelemetry.com?source=GitHubRepoReadme).

## Testing

```bash
composer test
```

## Changelog

Please see [RELEASE NOTES](https://github.com/thingstelemetry/laravel-traccar/releases) for more information on what has changed recently.

## Contributing

Please see [Contribution Guidelines](https://github.com/thingstelemetry/.github/blob/main/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Njogu Amos](https://github.com/njoguamos)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.