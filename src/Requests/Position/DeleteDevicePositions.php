<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Position;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Carbon\CarbonInterface;
use ThingsTelemetry\Traccar\Enums\Status;
use ThingsTelemetry\Traccar\Dto\StatusData;

class DeleteDevicePositions extends Request
{
    protected Method $method = Method::DELETE;

    public function __construct(
        public int $deviceId,
        protected CarbonInterface $from,
        protected CarbonInterface $to,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/positions';
    }

    public function createDtoFromResponse(Response $response): StatusData
    {
        return new StatusData(status: Status::SUCCESS);
    }

    /** @return array<string, int|string> */
    protected function defaultQuery(): array
    {
        return [
            'deviceId' => $this->deviceId,
            'from'     => $this->from->toIso8601String(),
            'to'       => $this->to->toIso8601String(),
        ];
    }
}
