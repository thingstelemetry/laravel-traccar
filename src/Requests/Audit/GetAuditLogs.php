<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Audit;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;
use ThingsTelemetry\Traccar\Dto\AuditData;

class GetAuditLogs extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        public ?CarbonImmutable $from = null,
        public ?CarbonImmutable $to = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/audit';
    }

    /** @return Collection<int, AuditData> */
    public function createDtoFromResponse(Response $response): Collection
    {
        return collect(value: $response->json())
            ->map(callback: fn (array $audit) => AuditData::fromArray(data: $audit));
    }

    /** @return array<string, mixed> */
    protected function defaultQuery(): array
    {
        return array_filter(array: [
            'from' => $this->from?->toIso8601String(),
            'to'   => $this->to?->toIso8601String(),
        ], callback: static fn (mixed $value): bool => $value !== null);
    }
}
