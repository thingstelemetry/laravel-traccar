<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Group;

use JsonException;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use InvalidArgumentException;
use Saloon\Contracts\Body\HasBody;
use Saloon\Traits\Body\HasJsonBody;
use ThingsTelemetry\Traccar\Dto\GroupData;

class UpdateGroup extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PUT;

    public function __construct(public GroupData $data)
    {
        if (is_null($data->id)) {
            throw new InvalidArgumentException(message: 'Group ID is required for update operations.');
        }
    }

    public function resolveEndpoint(): string
    {
        return '/groups/'.(int) $this->data->id;
    }

    /** @throws JsonException */
    public function createDtoFromResponse(Response $response): GroupData
    {
        $json = $response->json();

        if (! is_array($json) || $json === []) {
            throw new InvalidArgumentException(
                message: 'Invalid or empty JSON response from Traccar server.'
            );
        }

        return GroupData::fromArray(data: $json);
    }

    /** @return array<string, mixed> */
    protected function defaultBody(): array
    {
        return $this->data->toArray();
    }
}
