<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \ThingsTelemetry\Traccar\Dto\ServerData getInformation()
 * @method static \ThingsTelemetry\Traccar\Dto\ServerData updateInformation(\ThingsTelemetry\Traccar\Dto\ServerData $data)
 * @method static \ThingsTelemetry\Traccar\Dto\StatusData reboot()
 * @method static string cache()
 * @method static \ThingsTelemetry\Traccar\Dto\StatusData gc()
 * @method static \ThingsTelemetry\Traccar\Dto\StatusData uploadFile(string $path, \Illuminate\Http\UploadedFile|\Symfony\Component\HttpFoundation\File\File|string $file)
 * @method static \Illuminate\Support\Collection timezones()
 * @method static string geocode(float $latitude, float $longitude)
 * @method static \ThingsTelemetry\Traccar\Dto\ServerStatisticsData statistics(\Carbon\CarbonInterface $from, \Carbon\CarbonInterface $to)
 *
 * @see \ThingsTelemetry\Traccar\Endpoints\Server
 */
class Server extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \ThingsTelemetry\Traccar\Endpoints\Server::class;
    }
}
