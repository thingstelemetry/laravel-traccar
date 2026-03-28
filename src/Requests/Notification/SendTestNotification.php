<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Notification;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use ThingsTelemetry\Traccar\Enums\Status;
use ThingsTelemetry\Traccar\Dto\StatusData;

class SendTestNotification extends Request
{
    protected Method $method = Method::POST;

    public function __construct(protected ?string $notificator = null)
    {
    }

    public function resolveEndpoint(): string
    {
        if ($this->notificator !== null) {
            return "/notifications/test/{$this->notificator}";
        }

        return '/notifications/test';
    }

    public function createDtoFromResponse(Response $response): StatusData
    {
        return new StatusData(status: Status::SUCCESS);
    }
}
