<?php

declare(strict_types=1);

namespace TrackTelemetry\Traccar\Requests;

use JsonException;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use InvalidArgumentException;
use Saloon\Contracts\Body\HasBody;
use Saloon\Traits\Body\HasJsonBody;
use TrackTelemetry\Traccar\Dto\UserData;

class UpdateUser extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PUT;

    public function __construct(public UserData $data)
    {
        if ($data->id <= 0) {
            throw new InvalidArgumentException(message: 'User ID is required for update operations.');
        }
    }

    public function resolveEndpoint(): string
    {
        return "/users/{$this->data->id}";
    }

    /**
     * @throws JsonException
     */
    public function createDtoFromResponse(Response $response): UserData
    {
        return UserData::fromArray(data: $response->json());
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return $this->data->toArray();
    }
}
