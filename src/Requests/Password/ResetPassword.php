<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Password;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Contracts\Body\HasBody;
use Saloon\Traits\Body\HasFormBody;
use ThingsTelemetry\Traccar\Enums\Status;
use ThingsTelemetry\Traccar\Dto\StatusData;

class ResetPassword extends Request implements HasBody
{
    use HasFormBody;

    protected Method $method = Method::POST;

    public function __construct(protected string $email)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/password/reset';
    }

    public function createDtoFromResponse(Response $response): StatusData
    {
        return new StatusData(status: Status::SUCCESS);
    }

    protected function defaultBody(): array
    {
        return [
            'email' => $this->email,
        ];
    }
}
