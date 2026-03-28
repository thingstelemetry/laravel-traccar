<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Position;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Carbon\CarbonInterface;

class GetPositionsKml extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        private int $deviceId,
        private CarbonInterface $from,
        private CarbonInterface $to,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/positions/kml';
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

    /** @return array<string, string> */
    protected function defaultHeaders(): array
    {
        return [
            'Accept' => 'application/vnd.google-earth.kml+xml, */*',
        ];
    }
}
