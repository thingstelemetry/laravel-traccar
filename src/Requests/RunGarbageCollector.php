<?php

declare(strict_types=1);

namespace TrackTelemetry\Traccar\Requests;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use TrackTelemetry\Traccar\Enums\Status;
use TrackTelemetry\Traccar\Dto\StatusData;

class RunGarbageCollector extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/server/gc';
    }

    public function createDtoFromResponse(Response $response): StatusData
    {
        return new StatusData(status: Status::SUCCESS);
    }

    /**
     * Accept any response since Traccar may return empty or no content.
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
