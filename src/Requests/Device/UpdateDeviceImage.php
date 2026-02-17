<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Requests\Device;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class UpdateDeviceImage extends Request
{
    protected Method $method = Method::POST;

    public function __construct(
        public int $deviceId,
        protected string $mimeType,
        protected string $contents,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return "/devices/{$this->deviceId}/image";
    }

    public function createDtoFromResponse(Response $response): string
    {
        return mb_trim((string) $response->body());
    }

    /** @return array<string, string> */
    protected function defaultHeaders(): array
    {
        return [
            'Content-Type' => $this->mimeType,
            'Accept'       => 'text/plain, */*',
        ];
    }

    /** @return array<string, mixed> */
    protected function defaultConfig(): array
    {
        return [
            'body' => $this->contents,
        ];
    }
}
