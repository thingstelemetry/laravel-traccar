<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar;

use Saloon\Http\Connector;
use Saloon\Http\Auth\TokenAuthenticator;
use Saloon\Traits\Plugins\AlwaysThrowOnErrors;

class TraccarConnector extends Connector
{
    use AlwaysThrowOnErrors;

    /**
     * Create a new Traccar connector instance.
     *
     *
     * @return void
     */
    public function __construct(
        protected string $baseUrl,
        protected string $apiKey
    ) {
    }

    /**
     * Resolves and returns the base URL for the application.
     *
     * @return string The base URL.
     */
    public function resolveBaseUrl(): string
    {
        return $this->baseUrl;
    }

    /**
     * Provides the default authentication mechanism.
     */
    protected function defaultAuth(): TokenAuthenticator
    {
        return new TokenAuthenticator(token: $this->apiKey);
    }

    /**
     * Provides the default headers to be sent with each request.
     *
     * @return array<string, string>
     */
    protected function defaultHeaders(): array
    {
        return [
            'Content-Type' => 'application/json',
            'Accept'       => 'application/json',
        ];
    }
}
