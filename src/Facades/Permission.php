<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Facades;

use Illuminate\Support\Facades\Facade;
use ThingsTelemetry\Traccar\Dto\StatusData;
use ThingsTelemetry\Traccar\Dto\PermissionData;

/**
 * @method static StatusData link(PermissionData $data)
 * @method static StatusData unlink(PermissionData $data)
 * @method static StatusData linkBulk(array<PermissionData> $permissions)
 * @method static StatusData unlinkBulk(array<PermissionData> $permissions)
 */
class Permission extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \ThingsTelemetry\Traccar\Endpoints\Permission::class;
    }
}
