<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Position;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Carbon\CarbonInterface;

class GetPositionsCsv extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        private int $deviceId,
        private CarbonInterface $from,
        private CarbonInterface $to,
        private ?int $geofenceId = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/positions/csv';
    }

    public function createDtoFromResponse(Response $response): string
    {
        return mb_trim(string: $response->body());
    }

    /** @return array<string, int|string> */
    protected function defaultQuery(): array
    {
        $query = [
            'deviceId' => $this->deviceId,
            'from'     => $this->from->toIso8601String(),
            'to'       => $this->to->toIso8601String(),
        ];

        if ($this->geofenceId !== null) {
            $query['geofenceId'] = $this->geofenceId;
        }

        return $query;
    }

    /** @return array<string, string> */
    protected function defaultHeaders(): array
    {
        return [
            'Accept' => 'text/csv, */*',
        ];
    }
}
