<?php

declare(strict_types=1);

namespace TrackTelemetry\Traccar\Requests;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use TrackTelemetry\Traccar\Enums\Status;
use TrackTelemetry\Traccar\Dto\StatusData;

class RebootServer extends Request
{
    protected Method $method = Method::POST;

    /**
     * Resolves and returns the API endpoint for rebooting the server.
     */
    public function resolveEndpoint(): string
    {
        return '/server/reboot';
    }

    /**
     * Return a status enum from the response.
     */
    public function createDtoFromResponse(Response $response): StatusData
    {
        return new StatusData(status: Status::SUCCESS);
    }

    /**
     * Override headers to accept any content, since the server may return no content
     * or terminate the connection immediately during reboot.
     *
     * @return array<string, string>
     */
    protected function defaultHeaders(): array
    {
        return [
            'Accept' => '*/*',
        ];
    }
}
