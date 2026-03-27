<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Endpoints;

use Carbon\CarbonInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use ThingsTelemetry\Traccar\Traccar;
use Illuminate\Validation\Rules\File;
use Illuminate\Support\Facades\Validator;
use ThingsTelemetry\Traccar\Dto\DeviceData;
use ThingsTelemetry\Traccar\Dto\StatusData;
use ThingsTelemetry\Traccar\Dto\DeviceShareData;
use ThingsTelemetry\Traccar\Requests\Device\GetDevice;
use ThingsTelemetry\Traccar\Requests\Device\CreateDevice;
use ThingsTelemetry\Traccar\Requests\Device\DeleteDevice;
use ThingsTelemetry\Traccar\Requests\Device\UpdateDevice;
use ThingsTelemetry\Traccar\Requests\Device\GetAllDevices;
use Symfony\Component\HttpFoundation\File\File as SymfonyFile;
use ThingsTelemetry\Traccar\Requests\Device\GetForUserDevices;
use ThingsTelemetry\Traccar\Requests\Device\UpdateDeviceImage;
use ThingsTelemetry\Traccar\Requests\Device\UpdateDeviceTotals;

class Device extends Traccar
{
    /** @throws \Saloon\Exceptions\SaloonException */
    public function getAll(): Collection
    {
        $response = $this->connector->send(request: new GetAllDevices());

        return $response->dtoOrFail();
    }

    /** @throws \Saloon\Exceptions\SaloonException */
    public function find(int $id): DeviceData
    {
        $response = $this->connector->send(request: new GetDevice(id: $id));

        return $response->dtoOrFail();
    }

    /** @throws \Saloon\Exceptions\SaloonException */
    public function get(?int $userId = null, ?array $ids = null, ?array $uniqueIds = null): Collection
    {
        $response = $this->connector->send(
            request: new GetForUserDevices(
                userId: $userId,
                ids: $ids,
                uniqueIds: $uniqueIds
            )
        );

        return $response->dtoOrFail();
    }

    /** @throws \Saloon\Exceptions\SaloonException */
    public function create(DeviceData $data): DeviceData
    {
        $response = $this->connector->send(request: new CreateDevice(data: $data));

        return $response->dtoOrFail();
    }

    /** @throws \Saloon\Exceptions\SaloonException */
    public function update(DeviceData $data): DeviceData
    {
        $response = $this->connector->send(request: new UpdateDevice(data: $data));

        return $response->dtoOrFail();
    }

    /**
     * The path parameter `id` must equal the body `deviceId`.
     *
     * @throws \Saloon\Exceptions\SaloonException
     */
    public function updateTotals(int $deviceId, float $totalDistance, float $hours): StatusData
    {
        $response = $this->connector->send(
            request: new UpdateDeviceTotals(
                deviceId: $deviceId,
                totalDistance: $totalDistance,
                hours: $hours,
            )
        );

        return $response->dtoOrFail();
    }

    /** @throws \Saloon\Exceptions\SaloonException */
    public function delete(int $id): StatusData
    {
        $response = $this->connector->send(request: new DeleteDevice(id: $id));

        return $response->dtoOrFail();
    }

    /**
     * @throws \Saloon\Exceptions\SaloonException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateImage(int $deviceId, UploadedFile|SymfonyFile|string $file): string
    {
        // Normalize to Symfony File for consistent API
        if (is_string($file)) {
            $file = new SymfonyFile($file);
        }

        $data = [
            'device_id' => $deviceId,
            'file'      => $file,
        ];

        $rules = [
            'device_id' => ['required', 'integer', 'min:1'],
            'file'      => ['required', File::image(allowSvg: true)->max(500)],
        ];

        Validator::make($data, $rules)->validate();

        $mimeType = $file instanceof SymfonyFile
            ? ($file->getMimeType() ?? 'application/octet-stream')
            : 'application/octet-stream';

        $contents = file_get_contents($file->getPathname());

        $response = $this->connector->send(
            request: new UpdateDeviceImage(
                deviceId: $deviceId,
                mimeType: $mimeType,
                contents: $contents,
            )
        );

        return $response->dtoOrFail();
    }
}
