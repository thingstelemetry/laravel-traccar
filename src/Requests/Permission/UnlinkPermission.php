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

class UnlinkPermission extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::DELETE;

    public function __construct(public PermissionData $data)
    {
        $this->data->validate();
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
        return $this->data->toArray();
    }
}
