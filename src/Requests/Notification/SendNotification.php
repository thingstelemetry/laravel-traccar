<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Notification;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Contracts\Body\HasBody;
use Saloon\Traits\Body\HasJsonBody;
use ThingsTelemetry\Traccar\Enums\Status;
use ThingsTelemetry\Traccar\Dto\StatusData;
use ThingsTelemetry\Traccar\Dto\NotificationMessageData;

class SendNotification extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param  array<int>|null  $userIds
     */
    public function __construct(
        public string $notificator,
        public NotificationMessageData $message,
        public ?array $userIds = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return "/notifications/send/{$this->notificator}";
    }

    public function createDtoFromResponse(Response $response): StatusData
    {
        return new StatusData(status: Status::SUCCESS);
    }

    /** @return array<string, mixed> */
    protected function defaultBody(): array
    {
        return $this->message->toArray();
    }

    /** @return array<string, array<int>> */
    protected function defaultQuery(): array
    {
        return array_filter([
            'userId' => $this->userIds,
        ], static fn (mixed $value): bool => $value !== null);
    }
}
