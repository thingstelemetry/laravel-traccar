<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Report;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Carbon\CarbonInterface;
use Illuminate\Support\Collection;
use ThingsTelemetry\Traccar\Dto\ReportStopsData;

class GetStopsReport extends Request
{
    protected Method $method = Method::GET;

    /**
     * @param  array<int>  $deviceIds
     * @param  array<int>  $groupIds
     */
    public function __construct(
        public array $deviceIds,
        public array $groupIds,
        public CarbonInterface $from,
        public CarbonInterface $to,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/reports/stops';
    }

    /** @return Collection<int, ReportStopsData> */
    public function createDtoFromResponse(Response $response): Collection
    {
        return collect(value: $response->json())
            ->map(callback: fn (array $report) => ReportStopsData::fromArray(data: $report));
    }

    /** @return array<string, mixed> */
    protected function defaultQuery(): array
    {
        return array_filter([
            'deviceId' => $this->deviceIds,
            'groupId'  => $this->groupIds,
            'from'     => $this->from->toIso8601String(),
            'to'       => $this->to->toIso8601String(),
        ], static fn (mixed $value): bool => $value !== []);
    }
}
