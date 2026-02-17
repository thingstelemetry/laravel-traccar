<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Contracts\Body\HasBody;
use Saloon\Traits\Body\HasFormBody;
use ThingsTelemetry\Traccar\Enums\Status;
use ThingsTelemetry\Traccar\Dto\StatusData;

class RevokeSessionToken extends Request implements HasBody
{
    use HasFormBody;

    protected Method $method = Method::POST;

    public function __construct(public string $token)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/session/token/revoke';
    }

    public function createDtoFromResponse(Response $response): StatusData
    {
        return new StatusData(status: Status::SUCCESS);
    }

    /** @return array<string, mixed> */
    protected function defaultBody(): array
    {
        return [
            'token' => $this->token,
        ];
    }
}
