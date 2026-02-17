<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Session;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetOpenIdCallback extends Request
{
    protected Method $method = Method::GET;

    public function __construct(private string $queryString)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/session/openid/callback';
    }

    public function createDtoFromResponse(Response $response): string
    {
        return $response->header('Location') ?? '';
    }

    /**
     * @return array<string, string>
     */
    protected function defaultQuery(): array
    {
        $query = [];
        parse_str($this->queryString, $query);

        return $query;
    }
}
