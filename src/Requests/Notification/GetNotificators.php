<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Notification;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Illuminate\Support\Collection;
use ThingsTelemetry\Traccar\Dto\NotificationTypeData;

class GetNotificators extends Request
{
    protected Method $method = Method::GET;

    public function __construct(protected ?bool $announcement = null)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/notifications/notificators';
    }

    /** @return Collection<int, NotificationTypeData> */
    public function createDtoFromResponse(Response $response): Collection
    {
        return collect(value: $response->json())
            ->map(callback: fn (array $type) => NotificationTypeData::fromArray(data: $type));
    }

    /** @return array<string, bool> */
    protected function defaultQuery(): array
    {
        return array_filter([
            'announcement' => $this->announcement,
        ], static fn (mixed $value): bool => $value !== null);
    }
}
