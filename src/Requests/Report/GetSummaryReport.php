<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Report;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;
use ThingsTelemetry\Traccar\Dto\ReportSummaryData;

class GetSummaryReport extends Request
{
    protected Method $method = Method::GET;

    /**
     * @param  array<int>  $deviceIds
     * @param  array<int>  $groupIds
     */
    public function __construct(
        public array $deviceIds,
        public array $groupIds,
        public CarbonImmutable $from,
        public CarbonImmutable $to,
        public bool $daily = false,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/reports/summary';
    }

    /** @return Collection<int, ReportSummaryData> */
    public function createDtoFromResponse(Response $response): Collection
    {
        return collect(value: $response->json())
            ->map(callback: fn (array $report) => ReportSummaryData::fromArray(data: $report));
    }

    /** @return array<string, mixed> */
    protected function defaultQuery(): array
    {
        return array_filter([
            'deviceId' => $this->deviceIds,
            'groupId'  => $this->groupIds,
            'from'     => $this->from->toIso8601String(),
            'to'       => $this->to->toIso8601String(),
            'daily'    => $this->daily,
        ], static fn (mixed $value): bool => $value !== [] && $value !== null);
    }
}
