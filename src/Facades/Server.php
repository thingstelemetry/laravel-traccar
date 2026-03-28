<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Facades;

use Carbon\CarbonInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;
use ThingsTelemetry\Traccar\Dto\ServerData;
use ThingsTelemetry\Traccar\Dto\StatusData;
use Symfony\Component\HttpFoundation\File\File;

/**
 * @method static ServerData get()
 * @method static ServerData update(ServerData $data)
 * @method static StatusData reboot()
 * @method static string cache()
 * @method static StatusData runGarbageCollector()
 * @method static StatusData uploadFile(string $path, UploadedFile|File|string $file)
 * @method static Collection timezones()
 * @method static string geocode(float $latitude, float $longitude)
 * @method static \ThingsTelemetry\Traccar\Dto\ServerStatisticsData statistics(CarbonInterface $from, CarbonInterface $to)
 * @method static Collection<int, \ThingsTelemetry\Traccar\Dto\ServerStatisticsData> statisticsCollection(CarbonInterface $from, CarbonInterface $to)
 */
class Server extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \ThingsTelemetry\Traccar\Endpoints\Server::class;
    }
}
