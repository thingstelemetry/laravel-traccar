<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests;

use JsonException;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Contracts\Body\HasBody;
use Saloon\Traits\Body\HasFormBody;
use ThingsTelemetry\Traccar\Dto\UserData;

class CreateSession extends Request implements HasBody
{
    use HasFormBody;

    protected Method $method = Method::POST;

    public function __construct(
        public string $email,
        public string $password,
        public ?int $code = null
    ) {
    }

    /**
     * Resolves and returns the API endpoint for creating a session.
     */
    public function resolveEndpoint(): string
    {
        return '/session';
    }

    /** @throws JsonException */
    public function createDtoFromResponse(Response $response): UserData
    {
        return UserData::fromArray($response->json());
    }

    /** @return array<string, mixed> */
    protected function defaultBody(): array
    {
        $body = [
            'email'    => $this->email,
            'password' => $this->password,
        ];

        if ($this->code !== null) {
            $body['code'] = $this->code;
        }

        return $body;
    }
}
