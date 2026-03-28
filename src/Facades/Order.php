<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Illuminate\Support\Collection all(?bool $all = null, ?int $userId = null, ?bool $excludeAttributes = null, ?int $limit = null, ?int $offset = null, ?string $keyword = null)
 * @method static \ThingsTelemetry\Traccar\Dto\OrderData create(\ThingsTelemetry\Traccar\Dto\OrderData $data)
 * @method static \ThingsTelemetry\Traccar\Dto\OrderData update(\ThingsTelemetry\Traccar\Dto\OrderData $data)
 * @method static \ThingsTelemetry\Traccar\Dto\StatusData delete(int $id)
 *
 * @see \ThingsTelemetry\Traccar\Endpoints\Order
 */
class Order extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \ThingsTelemetry\Traccar\Endpoints\Order::class;
    }
}
