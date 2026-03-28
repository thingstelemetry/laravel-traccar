<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Abstract;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Carbon\CarbonInterface;

abstract class GetPositionsExportRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected int $deviceId,
        protected CarbonInterface $from,
        protected CarbonInterface $to,
    ) {
    }

    public function createDtoFromResponse(Response $response): string
    {
        return mb_trim(string: $response->body());
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
