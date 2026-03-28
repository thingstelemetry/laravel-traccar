<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Endpoints;

use Illuminate\Support\Collection;
use ThingsTelemetry\Traccar\Traccar;
use ThingsTelemetry\Traccar\Dto\StatusData;
use ThingsTelemetry\Traccar\Dto\AttributeData;
use ThingsTelemetry\Traccar\Requests\Attribute\CreateAttribute;
use ThingsTelemetry\Traccar\Requests\Attribute\DeleteAttribute;
use ThingsTelemetry\Traccar\Requests\Attribute\UpdateAttribute;
use ThingsTelemetry\Traccar\Requests\Attribute\GetAllAttributes;

class Attribute extends Traccar
{
    /** @throws \Saloon\Exceptions\SaloonException */
    public function all(?bool $all = null, ?int $userId = null, ?int $deviceId = null, ?int $groupId = null, ?bool $refresh = null, ?int $limit = null, ?int $offset = null, ?string $keyword = null): Collection
    {
        $response = $this->connector->send(
            request: new GetAllAttributes(
                all: $all,
                userId: $userId,
                deviceId: $deviceId,
                groupId: $groupId,
                refresh: $refresh,
                limit: $limit,
                offset: $offset,
                keyword: $keyword,
            )
        );

        return $response->dtoOrFail();
    }

    /** @throws \Saloon\Exceptions\SaloonException */
    public function create(AttributeData $data): AttributeData
    {
        return $this->connector->send(request: new CreateAttribute(data: $data))->dtoOrFail();
    }

    /** @throws \Saloon\Exceptions\SaloonException */
    public function update(AttributeData $data): AttributeData
    {
        return $this->connector->send(request: new UpdateAttribute(data: $data))->dtoOrFail();
    }

    /** @throws \Saloon\Exceptions\SaloonException */
    public function delete(int $id): StatusData
    {
        return $this->connector->send(request: new DeleteAttribute(id: $id))->dtoOrFail();
    }
}
