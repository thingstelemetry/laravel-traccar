<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Endpoints;

use ThingsTelemetry\Traccar\Traccar;
use ThingsTelemetry\Traccar\Dto\StatusData;
use ThingsTelemetry\Traccar\Dto\PermissionData;
use ThingsTelemetry\Traccar\Requests\Permission\LinkPermission;
use ThingsTelemetry\Traccar\Requests\Permission\UnlinkPermission;
use ThingsTelemetry\Traccar\Requests\Permission\LinkPermissionsBulk;
use ThingsTelemetry\Traccar\Requests\Permission\UnlinkPermissionsBulk;

class Permission extends Traccar
{
    /** @throws \Saloon\Exceptions\SaloonException */
    public function link(PermissionData $data): StatusData
    {
        $response = $this->connector->send(request: new LinkPermission(data: $data));

        return $response->dtoOrFail();
    }

    /** @throws \Saloon\Exceptions\SaloonException */
    public function unlink(PermissionData $data): StatusData
    {
        $response = $this->connector->send(request: new UnlinkPermission(data: $data));

        return $response->dtoOrFail();
    }

    /**
     * @param  array<PermissionData>  $permissions
     * @throws \Saloon\Exceptions\SaloonException
     */
    public function linkBulk(array $permissions): StatusData
    {
        $response = $this->connector->send(request: new LinkPermissionsBulk(permissions: $permissions));

        return $response->dtoOrFail();
    }

    /**
     * @param  array<PermissionData>  $permissions
     * @throws \Saloon\Exceptions\SaloonException
     */
    public function unlinkBulk(array $permissions): StatusData
    {
        $response = $this->connector->send(request: new UnlinkPermissionsBulk(permissions: $permissions));

        return $response->dtoOrFail();
    }
}
