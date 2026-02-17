<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Permission;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Contracts\Body\HasBody;
use Saloon\Traits\Body\HasJsonBody;
use ThingsTelemetry\Traccar\Enums\Status;
use ThingsTelemetry\Traccar\Dto\StatusData;
use ThingsTelemetry\Traccar\Dto\PermissionData;

class LinkPermissionsBulk extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param  array<PermissionData>  $permissions
     */
    public function __construct(public array $permissions)
    {
        foreach ($this->permissions as $permission) {
            $permission->validate();
        }
    }

    public function resolveEndpoint(): string
    {
        return '/permissions';
    }

    public function createDtoFromResponse(Response $response): StatusData
    {
        return new StatusData(status: Status::SUCCESS);
    }

    protected function defaultBody(): array
    {
        return array_map(fn (PermissionData $permission) => $permission->toArray(), $this->permissions);
    }
}
