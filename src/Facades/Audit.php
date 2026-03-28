<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Facades;

use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;
use ThingsTelemetry\Traccar\Dto\AuditData;

/**
 * @method static Collection<int, AuditData> get(?CarbonImmutable $from = null, ?CarbonImmutable $to = null)
 */
class Audit extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \ThingsTelemetry\Traccar\Endpoints\Audit::class;
    }
}
