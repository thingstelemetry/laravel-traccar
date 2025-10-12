<?php

declare(strict_types=1);

namespace TrackTelemetry\Traccar\Requests;

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

    /**
     * Resolves and returns the API endpoint for uploading a device image.
     */
    public function resolveEndpoint(): string
    {
        return "/devices/{$this->deviceId}/image";
    }

    /**
     * Return the filename string from the response body.
     */
    public function createDtoFromResponse(Response $response): string
    {
        return mb_trim((string) $response->body());
    }

    /**
     * Override headers to send binary image data.
     *
     * @return array<string, string>
     */
    protected function defaultHeaders(): array
    {
        return [
            'Content-Type' => $this->mimeType,
            'Accept'       => 'text/plain, */*',
        ];
    }

    /**
     * Provide the raw body contents (binary image data).
     *
     * @return array<string, mixed>
     */
    protected function defaultConfig(): array
    {
        return [
            'body' => $this->contents,
        ];
    }
}
