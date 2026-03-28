<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Password;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Contracts\Body\HasBody;
use Saloon\Traits\Body\HasFormBody;

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

    protected function defaultBody(): array
    {
        return [
            'email' => $this->email,
        ];
    }
}
