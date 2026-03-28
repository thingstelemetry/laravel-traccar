<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Position;

use JsonException;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Carbon\CarbonInterface;
use Illuminate\Support\Collection;
use ThingsTelemetry\Traccar\Dto\PositionData;

class GetPositions extends Request
{
    protected Method $method = Method::GET;

    /**
     * @param  array<int>|null  $ids
     */
    public function __construct(
        private ?int $deviceId = null,
        private ?CarbonInterface $from = null,
        private ?CarbonInterface $to = null,
        private ?array $ids = null,
        private ?int $geofenceId = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/positions';
    }

    /**
     * @return Collection<int, PositionData>
     *
     * @throws JsonException
     */
    public function createDtoFromResponse(Response $response): Collection
    {
        return collect(value: $response->json())
            ->map(callback: fn (array $position) => PositionData::fromArray(data: $position));
    }

    /** @return array<string, int|string|array<int, int>> */
    protected function defaultQuery(): array
    {
        $query = [];

        if ($this->deviceId !== null) {
            $query['deviceId'] = $this->deviceId;
        }

        if ($this->from !== null) {
            $query['from'] = $this->from->toIso8601String();
        }

        if ($this->to !== null) {
            $query['to'] = $this->to->toIso8601String();
        }

        if ($this->geofenceId !== null) {
            $query['geofenceId'] = $this->geofenceId;
        }

        if ($this->ids !== null && $this->ids !== []) {
            $query['id'] = array_map(
                callback: static fn (int $id): int => $id,
                array: $this->ids,
            );
        }

        return $query;
    }
}
