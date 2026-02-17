<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Server;

use JsonException;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Carbon\CarbonInterface;
use Illuminate\Support\Arr;
use ThingsTelemetry\Traccar\Dto\ServerStatisticsData;
use Saloon\Exceptions\Request\Statuses\NotFoundException;

class GetServerStatistics extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        private CarbonInterface $from,
        private CarbonInterface $to,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/statistics';
    }

    /** @throws JsonException */
    public function createDtoFromResponse(Response $response): ServerStatisticsData
    {
        $json = $response->json();

        if ($json === []) {
            throw new NotFoundException(
                response: $response,
                message: 'Statistics were not found. Check the date range and try again.'
            );
        }

        return ServerStatisticsData::fromArray(
            data: Arr::first(array: $json)
        );
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultQuery(): array
    {
        return [
            'from' => $this->from->toIso8601String(),
            'to'   => $this->to->toIso8601String(),
        ];
    }
}
