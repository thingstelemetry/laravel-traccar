<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Endpoints;

use Carbon\CarbonInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use ThingsTelemetry\Traccar\Traccar;
use Illuminate\Support\Facades\Validator;
use ThingsTelemetry\Traccar\Enums\Status;
use ThingsTelemetry\Traccar\Dto\ServerData;
use ThingsTelemetry\Traccar\Dto\StatusData;
use Illuminate\Validation\ValidationException;
use ThingsTelemetry\Traccar\Requests\RebootServer;
use Saloon\Exceptions\Request\FatalRequestException;
use ThingsTelemetry\Traccar\Requests\GetServerCache;
use ThingsTelemetry\Traccar\Requests\ReverseGeocode;
use ThingsTelemetry\Traccar\Dto\ServerStatisticsData;
use ThingsTelemetry\Traccar\Requests\UploadServerFile;
use ThingsTelemetry\Traccar\Requests\GetServerTimezones;
use ThingsTelemetry\Traccar\Requests\GetServerStatistics;
use ThingsTelemetry\Traccar\Requests\RunGarbageCollector;
use ThingsTelemetry\Traccar\Requests\GetServerInformation;
use ThingsTelemetry\Traccar\Requests\UpdateServerInformation;
use Symfony\Component\HttpFoundation\File\File as SymfonyFile;

class Server extends Traccar
{
    /**
     * Get server information
     *
     * @throws \Saloon\Exceptions\SaloonException
     */
    public function getInformation(): ServerData
    {
        $response = $this->connector->send(request: new GetServerInformation());

        return $response->dtoOrFail();
    }

    /**
     * Update server information
     *
     * @throws \Saloon\Exceptions\SaloonException
     */
    public function updateInformation(ServerData $data): ServerData
    {
        $response = $this->connector->send(request: new UpdateServerInformation($data));

        return $response->dtoOrFail();
    }

    /**
     * Reboot the Traccar server.
     *
     * Note: This endpoint is restricted to admin users only on the Traccar server.
     *
     * In practice, Traccar may terminate the HTTP process immediately during reboot,
     * causing an "Empty reply from server" (cURL error 52). We treat that specific
     * scenario as a successful initiation of reboot and return a success status.
     *
     * @throws \Saloon\Exceptions\SaloonException
     */
    public function reboot(): StatusData
    {
        try {
            $response = $this->connector->send(request: new RebootServer());

            return $response->dtoOrFail();
        } catch (FatalRequestException $e) {
            // cURL error 52: Empty reply from server
            if ($e->getCode() === 52) {
                return new StatusData(status: Status::SUCCESS);
            }

            throw $e;
        }
    }

    /**
     * Cache
     *
     * @throws \Saloon\Exceptions\SaloonException
     */
    public function cache(): string
    {
        $response = $this->connector->send(request: new GetServerCache());

        return $response->dtoOrFail();
    }

    /**
     * Trigger Garbage Collector
     *
     * @throws \Saloon\Exceptions\SaloonException
     */
    public function gc(): StatusData
    {
        $response = $this->connector->send(request: new RunGarbageCollector());

        return $response->dtoOrFail();
    }

    /**
     *
     * Accepts Laravel UploadedFile, Symfony File, or a filesystem path string. Sends the file
     * bytes to Traccar with the detected MIME type. No admin validation is enforced client-side;
     * Traccar server will handle permissions.
     *
     * @throws \Saloon\Exceptions\SaloonException
     * @throws ValidationException
     */
    public function uploadFile(string $path, UploadedFile|SymfonyFile|string $file): StatusData
    {
        // Normalize to Symfony File for consistent API
        if (is_string($file)) {
            $file = new SymfonyFile($file);
        }

        $data = [
            'path' => $path,
            'file' => $file,
        ];

        Validator::make($data, [
            'path' => ['required', 'string'],
            'file' => ['required'],
        ])->validate();

        $mimeType = $file instanceof SymfonyFile
            ? ($file->getMimeType() ?: 'application/octet-stream')
            : 'application/octet-stream';

        $contents = file_get_contents(filename: $file->getPathname());

        if ($contents === false) {
            throw ValidationException::withMessages([
                    'file' => ['Unable to read file contents.'],
                ]);
        }

        $response = $this->connector->send(
            request: new UploadServerFile(
                path: $path,
                mimeType: $mimeType,
                contents: $contents,
            )
        );

        return $response->dtoOrFail();
    }

    /**
     * Get timezones
     *
     * @return Collection<int, string>
     *
     * @throws \Saloon\Exceptions\SaloonException
     */
    public function timezones(): Collection
    {
        $response = $this->connector->send(request: new GetServerTimezones());

        return $response->dtoOrFail();
    }

    /**
     * Geocode coordinates
     *
     * @throws \Saloon\Exceptions\SaloonException
     */
    public function geocode(float $latitude, float $longitude): string
    {
        $response = $this->connector->send(request: new ReverseGeocode(latitude: $latitude, longitude: $longitude));

        return $response->dtoOrFail();
    }
    /**
     * Get aggregated server statistics between two timestamps.
     *
     * @throws \Saloon\Exceptions\SaloonException
     */
    public function statistics(CarbonInterface $from, CarbonInterface $to): ServerStatisticsData
    {
        $response = $this->connector->send(
            request: new GetServerStatistics(from: $from, to: $to)
        );

        return $response->dtoOrFail();
    }
}
