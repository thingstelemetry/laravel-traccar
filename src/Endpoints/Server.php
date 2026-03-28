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
use Saloon\Exceptions\Request\FatalRequestException;
use ThingsTelemetry\Traccar\Dto\ServerStatisticsData;
use ThingsTelemetry\Traccar\Requests\Server\RebootServer;
use ThingsTelemetry\Traccar\Requests\Server\GetServerCache;
use ThingsTelemetry\Traccar\Requests\Server\ReverseGeocode;
use ThingsTelemetry\Traccar\Requests\Server\UploadServerFile;
use Symfony\Component\HttpFoundation\File\File as SymfonyFile;
use ThingsTelemetry\Traccar\Requests\Server\GetServerTimezones;
use ThingsTelemetry\Traccar\Requests\Server\GetServerStatistics;
use ThingsTelemetry\Traccar\Requests\Server\RunGarbageCollector;
use ThingsTelemetry\Traccar\Requests\Server\GetServerInformation;
use ThingsTelemetry\Traccar\Requests\Server\UpdateServerInformation;

class Server extends Traccar
{
    /** @throws \Saloon\Exceptions\SaloonException */
    public function get(): ServerData
    {
        $response = $this->connector->send(request: new GetServerInformation());

        return $response->dtoOrFail();
    }

    /** @throws \Saloon\Exceptions\SaloonException */
    public function update(ServerData $data): ServerData
    {
        $response = $this->connector->send(request: new UpdateServerInformation(data: $data));

        return $response->dtoOrFail();
    }

    /**
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

    /** @throws \Saloon\Exceptions\SaloonException */
    public function cache(): string
    {
        $response = $this->connector->send(request: new GetServerCache());

        return $response->dtoOrFail();
    }

    /** @throws \Saloon\Exceptions\SaloonException */
    public function runGarbageCollector(): StatusData
    {
        $response = $this->connector->send(request: new RunGarbageCollector());

        return $response->dtoOrFail();
    }

    /**
     * @throws \Saloon\Exceptions\SaloonException
     * @throws \Illuminate\Validation\ValidationException
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
     * @return Collection<int, string>
     *
     * @throws \Saloon\Exceptions\SaloonException
     */
    public function timezones(): Collection
    {
        $response = $this->connector->send(request: new GetServerTimezones());

        return $response->dtoOrFail();
    }

    /** @throws \Saloon\Exceptions\SaloonException */
    public function geocode(float $latitude, float $longitude): string
    {
        $response = $this->connector->send(request: new ReverseGeocode(latitude: $latitude, longitude: $longitude));

        return $response->dtoOrFail();
    }

    /**
     * @return ServerStatisticsData
     *
     * @throws \Saloon\Exceptions\SaloonException
     */
    public function statistics(CarbonInterface $from, CarbonInterface $to): ServerStatisticsData
    {
        $response = $this->connector->send(
            request: new GetServerStatistics(from: $from, to: $to)
        );

        /** @var Collection<int, ServerStatisticsData> $collection */
        $collection = $response->dtoOrFail();

        return $collection->first();
    }

    /**
     * @return Collection<int, ServerStatisticsData>
     *
     * @throws \Saloon\Exceptions\SaloonException
     */
    public function statisticsCollection(CarbonInterface $from, CarbonInterface $to): Collection
    {
        $response = $this->connector->send(
            request: new GetServerStatistics(from: $from, to: $to)
        );

        return $response->dtoOrFail();
    }
}
