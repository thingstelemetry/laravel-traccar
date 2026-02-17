<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests;

use JsonException;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Illuminate\Support\Collection;
use ThingsTelemetry\Traccar\Dto\DeviceData;

class GetForUserDevices extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        public ?int $userId = null,
        public ?array $ids = null,
        public ?array $uniqueIds = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return "/devices?{$this->getQueryParam()}";
    }

    /** @throws JsonException */
    public function createDtoFromResponse(Response $response): Collection
    {
        return collect(value: $response->json())
            ->map(callback: fn ($device) => DeviceData::fromArray(data: $device));
    }

    protected function getQueryParam(): string
    {
        $query = '';

        if ($this->userId) {
            $query = 'userId='.$this->userId;
        }

        if ($this->ids) {
            $ids = collect($this->ids)
                ->map(fn ($id) => "id={$id}")
                ->join('&');

            $query .= ($query ? '&' : '').$ids;
        }

        if ($this->uniqueIds) {
            $uniqueIds = collect($this->uniqueIds)
                ->map(fn ($id) => "uniqueId={$id}")
                ->join('&');

            $query .= ($query ? '&' : '').$uniqueIds;
        }

        return $query;
    }
}
