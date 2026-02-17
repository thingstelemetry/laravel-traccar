# AI Development Instructions

## Project Overview

This is **Laravel Traccar** - a PHP Laravel package that provides an elegant API client for the [Traccar GPS Tracking Platform](https://www.traccar.org/). The package uses [Saloon PHP](https://docs.saloon.dev/) as its HTTP client foundation.

- **Package Name:** `thingstelemetry/laravel-traccar`
- **PHP Version:** ^8.4
- **Laravel Version:** ^12.x
- **License:** MIT
- **Author:** Njogu Amos (njoguamos@gmail.com)

## Architecture

### Directory Structure

```
├── config/           # Package configuration
├── docs/             # Documentation (VitePress)
├── src/              # Source code
│   ├── Dto/          # Data Transfer Objects
│   ├── Endpoints/    # API endpoint classes (Server, Device, User, etc.)
│   ├── Enums/        # PHP enums for type safety
│   ├── Facades/      # Laravel facades
│   ├── Requests/     # Saloon request classes
│   └── Support/      # Helper classes
├── tests/            # Pest PHP tests
│   ├── Feature/      # Feature tests
│   ├── Unit/         # Unit tests
│   ├── Pest.php      # Pest configuration
│   └── TestCase.php  # Base test case
└── workbench/        # Laravel testbench for development
```

### Core Patterns

1. **Saloon HTTP:** `TraccarConnector` (auth & headers) → `Request` classes (per endpoint) → DTOs via `createDtoFromResponse()`
2. **Endpoints:** Extend `Traccar` base class, return typed DTOs, accessible via facades
3. **DTOs:** Have `fromArray()` constructor and `toArray()` serialization, support nested DTOs
4. **Enums:** Backed enums (string values), have `default()` method for fallback
5. **Support Classes:** Utilities in `src/Support/` with unit tests in `tests/Unit/Services/`
6. **Service Provider:** Binds `TraccarConnector` to container, publishes config
7. **Facades:** Static access via `Server::getInformation()` instead of `app(Server::class)->getInformation()`

## Coding Standards

### PHP Style (Pint Configuration)

Run formatting with: `composer format`

Key rules from `pint.json`:

- **Preset:** PSR-12
- **Strict types:** Required (`declare(strict_types=1);`)
- **Array syntax:** Short `[]`
- **Imports:** Sorted by length
- **Class elements:** Ordered (traits, constants, properties, constructor, methods)
- **Binary operators:** Aligned (`=>`)
- **Date/Time immutability:** Encourages immutable datetime objects (`date_time_immutable`)
- **Multibyte strings:** Uses `mb_` string functions (`mb_str_functions`)
- **Modern type casting:** Modernizes type casting syntax (`modernize_types_casting`)
- **Global imports:** Imports classes, constants, and functions globally (`global_namespace_import`)
- **Access modifiers:** Converts `protected` to `private` where possible (`protected_to_private`)

### Code Style Examples

```php
<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetServerInformation extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/server';
    }
}
```

### DTO Example

```php
<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Dto;

class ServerData
{
    public function __construct(
        public int $id,
        public string $version,
        // ... other properties
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            version: $data['version'],
            // ...
        );
    }

    public function toArray(): array
    {
        return [
            'id'      => $this->id,
            'version' => $this->version,
            // ...
        ];
    }
}
```

### Support/Service Class Example

```php
<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Support;

class StorageInfo
{
    public function __construct(
        public string $storage,
        public int $free,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            storage: $data['storage'],
            free: $data['free'],
        );
    }
}
```

## Testing

Run tests: `composer test`

- **`tests/Feature/`** - Integration tests (endpoint methods, HTTP cycles)
- **`tests/Unit/`** - Unit tests (`TraccarConnectorTest.php`, `Services/` folder)
- **`tests/Unit/Services/`** - Support class tests (`MountTest.php`, `StorageInfoTest.php`)

### Key Patterns

```php
// Mock HTTP requests
MockClient::global([
    GetServerInformation::class => MockResponse::make(['id' => 1, 'version' => '6.10'])
]);

// Test support classes
$storageInfo = StorageInfo::fromArray(['storage' => '/var/traccar', 'free' => 5368709120]);
expect($storageInfo->storage)->toBe('/var/traccar');

// Test DTOs
$serverData = new ServerData(id: 1, version: '6.10');
expect($serverData->toArray()['id'])->toBe(1);
```

- Configure in `tests/Pest.php` with `Config::preventStrayRequests()` - all HTTP requests must be mocked
- Use `test()` or `it()` functions with descriptive names

## Environment Variables

```bash
TRACCAR_API_KEY=your-api-key
TRACCAR_BASE_URL=https://demo.traccar.org/api
```

## Service Provider & Configuration

The `TraccarServiceProvider` (in `src/TraccarServiceProvider.php`):

```php
public function register(): void
{
    $this->app->bind(TraccarConnector::class, function (): TraccarConnector {
        return new TraccarConnector(
            baseUrl: config()->string(key: 'traccar.base_url'),
            apiKey: config()->string(key: 'traccar.api_key')
        );
    });
}

public function boot(): void
{
    $this->mergeConfigFrom(__DIR__ . '/../config/traccar.php', 'traccar');
    $this->publishes([__DIR__ . '/../config/traccar.php' => config_path('traccar.php')], 'config');
}
```

Publish config: `php artisan vendor:publish --tag=config --provider="ThingsTelemetry\Traccar\TraccarServiceProvider"`

## Using Facades

```php
use ThingsTelemetry\Traccar\Facades\Server;
use ThingsTelemetry\Traccar\Facades\Device;

$serverInfo = Server::getInformation(); // Instead of: app(Server::class)->getInformation()
```

Each facade implements `getFacadeAccessor()` pointing to its endpoint class.

## Available Commands

| Command           | Description                    |
|-------------------|--------------------------------|
| `composer test`   | Run Pest tests                 |
| `composer format` | Run Laravel Pint (format code) |
| `composer lint`   | Check code style with Pint     |
| `composer serve`  | Start development server       |
| `composer build`  | Build workbench                |

## Adding New Features

### Adding a New API Endpoint

1. **Create the Request class** in `src/Requests/`:

```php
<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetSomething extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/something';
    }

    public function createDtoFromResponse(Response $response): SomethingData
    {
        return SomethingData::fromArray($response->json());
    }
}
```

2. **Create the DTO** in `src/Dto/`:

```php
<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Dto;

class SomethingData
{
    public function __construct(public int $id, public string $name) {}

    public static function fromArray(array $data): self
    {
        return new self(id: $data['id'], name: $data['name']);
    }
}
```

3. **Add to Endpoint** in `src/Endpoints/`, write tests in `tests/Feature/`:

### Adding a Support/Service Class

Create in `src/Support/`:

```php
<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Support;

class MyHelper
{
    public function __construct(public string $value) {}

    public static function fromArray(array $data): self
    {
        return new self(value: $data['value']);
    }
}
```

Test in `tests/Unit/Services/`:

```php
use ThingsTelemetry\Traccar\Support\MyHelper;

test('my helper from array', function () {
    $helper = MyHelper::fromArray(['value' => 'test']);
    expect($helper->value)->toBe('test');
});
```

### Adding a New Enum

```php
<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Enums;

enum Status: string
{
    case ACTIVE   = 'active';
    case INACTIVE = 'inactive';

    public static function default(): self
    {
        return self::ACTIVE;
    }
}
```

## Important Notes

1. **Always use `declare(strict_types=1);`** at the top of every PHP file
2. **Type hint everything** - properties, parameters, return types
3. **Use constructor property promotion** where appropriate
4. **Prefer named arguments** for DTO constructors
5. **Handle null values** with null coalescing operator `??` in DTOs
6. **Use `dtoOrFail()`** when expecting DTOs from responses
7. **Mock all HTTP requests** in tests - stray requests are prevented
8. **Follow PSR-12** and run `composer format` before committing

# Use Semantic Commit Messages

- `feat`: (new feature for the user, not a new feature for a build script)
- `fix`: (bug fix for the user, not a fix to a build script)
- `docs`: (changes to the documentation)
- `style`: (formatting, missing semicolons, etc.; no production code change)
- `refactor`: (refactoring production code, e.g. renaming a variable)
- `test`: (adding missing tests, refactoring tests; no production code change)
- `chore`: (updating grunt tasks etc.; no production code change)

## CI/CD

GitHub Actions runs:
- PHP 8.4, 8.5
- Laravel 12.*
- Tests with coverage

## Documentation

Full documentation is in `docs/` and deployed to [traccar.thingstelemetry.com](https://traccar.thingstelemetry.com)
