<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Position;

use Carbon\CarbonInterface;
use ThingsTelemetry\Traccar\Requests\Abstract\GetPositionsExportRequest;

class GetPositionsCsv extends GetPositionsExportRequest
{
    public function __construct(
        int $deviceId,
        CarbonInterface $from,
        CarbonInterface $to,
        private ?int $geofenceId = null,
    ) {
        parent::__construct(
            deviceId: $deviceId,
            from: $from,
            to: $to,
        );
    }

    public function resolveEndpoint(): string
    {
        return '/positions/csv';
    }

    /** @return array<string, int|string> */
    protected function defaultQuery(): array
    {
        $query = parent::defaultQuery();

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
