<?php

declare(strict_types=1);

namespace TrackTelemetry\Traccar\Endpoints;

use Carbon\CarbonInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use TrackTelemetry\Traccar\Traccar;
use Illuminate\Validation\Rules\File;
use TrackTelemetry\Traccar\Enums\Status;
use Illuminate\Support\Facades\Validator;
use TrackTelemetry\Traccar\Dto\DeviceData;
use Illuminate\Validation\ValidationException;
use TrackTelemetry\Traccar\Requests\ShareDevice;
use TrackTelemetry\Traccar\Requests\CreateDevice;
use TrackTelemetry\Traccar\Requests\DeleteDevice;
use TrackTelemetry\Traccar\Requests\UpdateDevice;
use TrackTelemetry\Traccar\Requests\GetAllDevices;
use TrackTelemetry\Traccar\Requests\GetForUserDevices;
use TrackTelemetry\Traccar\Requests\UpdateDeviceImage;
use TrackTelemetry\Traccar\Requests\UpdateDeviceTotals;
use Symfony\Component\HttpFoundation\File\File as SymfonyFile;

class Device extends Traccar
{
    /**
     * Get all devices
     *
     * @throws \Saloon\Exceptions\SaloonException
     */
    public function getAll(): Collection
    {
        $response = $this->connector->send(request: new GetAllDevices());

        return $response->dtoOrFail();
    }

    /**
     * Get devices by id, unique id or user id
     * or returns a list of the user's devices
     *
     * @throws \Saloon\Exceptions\SaloonException
     */
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

    /**
     * Create a new device.
     *
     * @throws \Saloon\Exceptions\SaloonException
     */
    public function create(DeviceData $data): DeviceData
    {
        $response = $this->connector->send(request: new CreateDevice(data: $data));

        return $response->dtoOrFail();
    }

    /**
     * Update an existing device.
     *
     * @throws \Saloon\Exceptions\SaloonException
     */
    public function update(DeviceData $data): DeviceData
    {
        $response = $this->connector->send(request: new UpdateDevice(data: $data));

        return $response->dtoOrFail();
    }

    /**
     * Update total distance and hours of the Device.
     *
     * Note: The path parameter `id` must equal the body `deviceId`.
     *
     * @throws \Saloon\Exceptions\SaloonException
     */
    public function updateTotals(int $deviceId, float $totalDistance, float $hours): Status
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

    /**
     * Delete a device by ID.
     *
     * @throws \Saloon\Exceptions\SaloonException
     */
    public function delete(int $id): Status
    {
        $response = $this->connector->send(request: new DeleteDevice(id: $id));

        return $response->dtoOrFail();
    }

    /**
     * Upload/Update device image.
     *
     * Validates the image before sending to Traccar and streams the raw bytes with the correct
     * Content-Type header as required by the Traccar API (Consumes: image/*).
     *
     * @throws \Saloon\Exceptions\SaloonException
     * @throws ValidationException
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

    /**
     * Share a device and receive a temporary access token.
     *
     * Accepts a Carbon instance for expiration and converts it to ISO-8601 before submitting
     * as application/x-www-form-urlencoded data as expected by Traccar.
     *
     * @throws \Saloon\Exceptions\SaloonException
     */
    public function share(int $deviceId, CarbonInterface $expiration): \TrackTelemetry\Traccar\Dto\DeviceShareData
    {
        $response = $this->connector->send(
            request: new ShareDevice(
                deviceId: $deviceId,
                expiration: $expiration,
            )
        );

        return $response->dtoOrFail();
    }
}
