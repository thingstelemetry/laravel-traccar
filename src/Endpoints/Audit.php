<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Endpoints;

use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;
use ThingsTelemetry\Traccar\Traccar;
use ThingsTelemetry\Traccar\Dto\AuditData;
use ThingsTelemetry\Traccar\Requests\Audit\GetAuditLogs;

class Audit extends Traccar
{
    /**
     * @return Collection<int, AuditData>
     *
     * @throws \Saloon\Exceptions\SaloonException
     */
    public function get(?CarbonImmutable $from = null, ?CarbonImmutable $to = null): Collection
    {
        $response = $this->connector->send(request: new GetAuditLogs(from: $from, to: $to));

        return $response->dtoOrFail();
    }
}
