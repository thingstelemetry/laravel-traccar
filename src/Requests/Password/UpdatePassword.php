<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Password;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Contracts\Body\HasBody;
use Saloon\Traits\Body\HasFormBody;

class UpdatePassword extends Request implements HasBody
{
    use HasFormBody;

    protected Method $method = Method::POST;

    public function __construct(
        protected string $token,
        protected string $password,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/password/update';
    }

    protected function defaultBody(): array
    {
        return [
            'token'    => $this->token,
            'password' => $this->password,
        ];
    }
}
