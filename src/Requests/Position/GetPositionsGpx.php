<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Position;

use ThingsTelemetry\Traccar\Requests\Abstract\GetPositionsExportRequest;

class GetPositionsGpx extends GetPositionsExportRequest
{
    public function resolveEndpoint(): string
    {
        return '/positions/gpx';
    }

    /** @return array<string, string> */
    protected function defaultHeaders(): array
    {
        return [
            'Accept' => 'application/gpx+xml, */*',
        ];
    }
}
