<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Server;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Carbon\CarbonInterface;
use Illuminate\Support\Collection;
use ThingsTelemetry\Traccar\Dto\ServerStatisticsData;

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

    /**
     * @return Collection<int, ServerStatisticsData>
     */
    public function createDtoFromResponse(Response $response): Collection
    {
        return $response->collect()->map(
            fn (array $data) => ServerStatisticsData::fromArray(data: $data)
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
