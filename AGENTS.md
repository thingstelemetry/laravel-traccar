# AI Development Instructions

## Project Overview

This is **Laravel Traccar** - a PHP Laravel package that provides an elegant API client for the [Traccar GPS Tracking Platform](https://www.traccar.org/). The package uses [Saloon PHP](https://docs.saloon.dev/) as its HTTP client foundation.

- **Package Name:** `thingstelemetry/laravel-traccar`
- **PHP Version:** ^8.4 || ^8.5
- **Laravel Version:** ^12.x || ^13.x
- **License:** MIT
- **Author:** Njogu Amos (njoguamos@gmail.com)

## Architecture

### Directory Structure

```text
├── config/           # Package configuration
├── docs/             # Documentation (VitePress)
├── src/              # Source code
│   ├── Dto/          # Data Transfer Objects
│   ├── Endpoints/    # API endpoint classes (Server, Device, User, etc.)
│   ├── Enums/        # PHP enums for type safety
│   ├── Facades/      # Laravel facades
│   ├── Requests/     # Saloon request classes
│   ├── Support/      # Helper classes
│   ├── Traccar.php   # Base class for endpoints
│   ├── TraccarConnector.php   # Saloon connector
│   └── TraccarServiceProvider.php # Laravel service provider
├── tests/            # Pest PHP tests
│   ├── Feature/      # Feature tests
│   ├── Unit/         # Unit tests
│   ├── Pest.php      # Pest configuration
│   └── TestCase.php  # Base test case
└── workbench/        # Laravel testbench for development
```

## Agent Skills

Agent Skills are modular capabilities that extend your functionality with specialized instructions and resources.

### Available Skills

- **commit**: Use for managing commits, branching, and pull requests in the Laravel Traccar project to ensure a clean and logical git history.

### How to Use Agent Skills

1. **When to use**: Consider using an Agent Skill when the task matches a skill's description. Skills provide domain-specific guidance, scripts, templates, and best practices.
2. **Reading skill documentation**:
   - To read the main skill body: use `agent_skill_read_doc` tool with only the `name` parameter (omit `path`).
   - To read referenced files: use `agent_skill_read_doc` tool with both `name` and `path` parameters.
   - Always read the skill body first to understand available resources and instructions.
3. **Working with skill scripts**: If a skill provides scripts (e.g., in `scripts/` directory), execute them using the `bash` tool. Read the script documentation first to understand required parameters and usage.
4. **Skill selection**: When you sense a task might benefit from specialized guidance (e.g., code review, testing, documentation), check if a relevant skill exists and read its documentation before proceeding.

### Core Patterns

1. **Saloon HTTP:** `TraccarConnector` uses `AlwaysThrowOnErrors` trait and `TokenAuthenticator`. It defines `defaultHeaders()` and `resolveBaseUrl()`.
2. **Endpoints:** Classes in `src/Endpoints/` extend `Traccar` base class. They use `$this->connector->send(request: new RequestClass())->dtoOrFail()` to return typed DTOs.
3. **DTOs:** Have `fromArray()` static constructor and `toArray()` method. They use constructor property promotion and type-hinted properties. Support nested DTOs (e.g., `ServerData` has `ServerAttributesData`).
4. **Enums:** Backed enums (string values), typically have a `default()` method for fallback and use `tryFrom()` with a fallback to `default()` when instantiating from data.
5. **Support Classes:** Utilities in `src/Support/` with unit tests in `tests/Unit/Services/` (historical naming; keep tests in `tests/Unit/Services/` for `src/Support/` classes). Examples: `Mount` and `StorageInfo`.
6. **Service Provider:** Binds `TraccarConnector` to the container using named arguments in `config()` and `app()`. Publishes and merges config.
7. **Facades:** Static access via `Server::getInformation()` instead of `app(Server::class)->getInformation()`. Accessible via `ThingsTelemetry\Traccar\Facades` namespace.
8. **Base Traccar Class:** `src/Traccar.php` is an abstract class that initializes the `$connector` property by resolving it from the Laravel container in its constructor.

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
- **Named Arguments:** Use named arguments for functions and methods when appropriate (e.g., in `TraccarServiceProvider`).

### Code Style Examples

#### Request Example

```php
<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Server;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use ThingsTelemetry\Traccar\Dto\ServerData;

class GetServerInformation extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/server';
    }

    public function createDtoFromResponse(Response $response): ServerData
    {
        return ServerData::fromArray($response->json());
    }
}
```

#### DTO Example

```php
<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Dto;

class ServerData
{
    public function __construct(
        public int $id,
        public string $version,
        public ServerAttributesData $attributes,
        // ... other properties
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            version: $data['version'],
            attributes: ServerAttributesData::fromArray(data: $data['attributes'] ?? []),
            // ...
        );
    }

    public function toArray(): array
    {
        return [
            'id'      => $this->id,
            'version' => $this->version,
            'attributes' => $this->attributes->toArray(),
            // ...
        ];
    }
}
```

#### Support Class Example

```php
<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Support;

class Mount
{
    public function __construct(public int $free, public int $total) {}

    public function freeFormatted(): string
    {
        // ... formatting logic
    }
}
```

## Testing

Run tests: `composer test`

- **`tests/Feature/`** - Integration tests (endpoint methods, HTTP cycles).
- **`tests/Unit/`** - Unit tests (`TraccarConnectorTest.php`, `Services/` folder).
- **`tests/Unit/Services/`** - Support class tests (`MountTest.php`, `StorageInfoTest.php`); this folder intentionally covers `src/Support/`.

### Key Patterns

```php
// Mock HTTP requests
MockClient::global([
    GetServerInformation::class => MockResponse::make(['id' => 1, 'version' => '6.10'])
]);

// Test support classes
$mount = new Mount(free: 1024, total: 2048);
expect($mount->free)->toBe(1024);

// Test DTOs
$serverData = new ServerData(id: 1, version: '6.10', attributes: new ServerAttributesData());
expect($serverData->toArray()['id'])->toBe(1);
```

- Configure in `tests/Pest.php` with `Config::preventStrayRequests()` - all HTTP requests must be mocked.
- Use `test()` or `it()` functions with descriptive names.

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
    $this->app->bind(
        abstract: TraccarConnector::class,
        concrete: function (): TraccarConnector {
            return new TraccarConnector(
                baseUrl: config()->string(key: 'traccar.base_url'),
                apiKey: config()->string(key: 'traccar.api_key')
            );
        }
    );
}

public function boot(): void
{
    $this->mergeConfigFrom(path: __DIR__ . '/../config/traccar.php', key: 'traccar');
    $this->publishes(paths: [__DIR__ . '/../config/traccar.php' => config_path('traccar.php')], groups: 'config');
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

1. **Create the Request class** in `src/Requests/{Entity}/`:

```php
<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Something;

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

    public function toArray(): array
    {
        return ['id' => $this->id, 'name' => $this->name];
    }
}
```

3. **Add to Endpoint** in `src/Endpoints/`, write tests in `tests/Feature/`. Endpoints should use `dtoOrFail()` on the response.

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

1. **Always use `declare(strict_types=1);`** at the top of every PHP file.
2. **Type hint everything** - properties, parameters, return types.
3. **Use constructor property promotion** where appropriate.
4. **Prefer named arguments** for functions and DTO constructors (e.g., `new self(id: $data['id'])`).
5. **Handle null values** with null coalescing operator `??` or explicit checks in DTOs.
6. **Use `dtoOrFail()`** when expecting DTOs from responses.
7. **Mock all HTTP requests** in tests - stray requests are prevented.
8. **Follow PSR-12** and run `composer format` before committing.
9. **Follow Named Parameters style** for Laravel helper functions like `app()`, `config()`, `Validator::make()`, etc.
10. **Use Semantic Commit Messages** 
11. **Use GitHub CLI (`gh`)** for all GitHub-related operations (e.g., creating PRs, checking status, etc.).

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
- Laravel 12.*, 13.*
- Tests with coverage

## Documentation

Full documentation is in `docs/` and deployed to [traccar.thingstelemetry.com](https://traccar.thingstelemetry.com)