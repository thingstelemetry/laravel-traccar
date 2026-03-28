<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Command;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Contracts\Body\HasBody;
use Saloon\Traits\Body\HasJsonBody;
use ThingsTelemetry\Traccar\Dto\CommandData;
use ThingsTelemetry\Traccar\Dto\CommandDispatchResultData;

class SendCommand extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        public CommandData $data,
        public ?int $groupId = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/commands/send';
    }

    public function createDtoFromResponse(Response $response): CommandDispatchResultData
    {
        return CommandDispatchResultData::fromArray(data: $response->json());
    }

    /** @return array<string, mixed> */
    protected function defaultBody(): array
    {
        return $this->data->toArray();
    }

    /** @return array<string, int> */
    protected function defaultQuery(): array
    {
        return array_filter([
            'groupId' => $this->groupId,
        ], static fn (mixed $value): bool => $value !== null);
    }
}
