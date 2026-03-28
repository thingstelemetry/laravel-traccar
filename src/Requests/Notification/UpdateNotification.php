<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Notification;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use InvalidArgumentException;
use Saloon\Contracts\Body\HasBody;
use Saloon\Traits\Body\HasJsonBody;
use ThingsTelemetry\Traccar\Dto\NotificationData;

class UpdateNotification extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PUT;

    public function __construct(public NotificationData $data)
    {
        if (is_null($data->id)) {
            throw new InvalidArgumentException(message: 'Notification ID is required for update operations.');
        }
    }

    public function resolveEndpoint(): string
    {
        return "/notifications/{$this->data->id}";
    }

    public function createDtoFromResponse(Response $response): NotificationData
    {
        return NotificationData::fromArray(data: $response->json());
    }

    /** @return array<string, mixed> */
    protected function defaultBody(): array
    {
        return $this->data->toArray();
    }
}
