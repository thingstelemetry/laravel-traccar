<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Illuminate\Support\Collection getAll(?bool $all = null, ?int $userId = null, ?int $deviceId = null, ?int $groupId = null, ?bool $refresh = null, ?int $limit = null, ?int $offset = null, ?string $keyword = null)
 * @method static \ThingsTelemetry\Traccar\Dto\AttributeData create(\ThingsTelemetry\Traccar\Dto\AttributeData $data)
 * @method static \ThingsTelemetry\Traccar\Dto\AttributeData update(\ThingsTelemetry\Traccar\Dto\AttributeData $data)
 * @method static \ThingsTelemetry\Traccar\Dto\StatusData delete(int $id)
 *
 * @see \ThingsTelemetry\Traccar\Endpoints\Attribute
 */
class Attribute extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \ThingsTelemetry\Traccar\Endpoints\Attribute::class;
    }
}
