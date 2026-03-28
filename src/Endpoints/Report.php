<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Endpoints;

use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;
use ThingsTelemetry\Traccar\Traccar;
use Illuminate\Validation\ValidationException;
use ThingsTelemetry\Traccar\Requests\Report\GetRouteReport;
use ThingsTelemetry\Traccar\Requests\Report\GetStopsReport;
use ThingsTelemetry\Traccar\Requests\Report\GetTripsReport;
use ThingsTelemetry\Traccar\Requests\Report\GetEventsReport;
use ThingsTelemetry\Traccar\Requests\Report\GetSummaryReport;
use ThingsTelemetry\Traccar\Requests\Report\GetGeofencesReport;

class Report extends Traccar
{
    /**
     * @param  array<int>  $deviceIds
     * @param  array<int>  $groupIds
     *
     * @throws \Saloon\Exceptions\SaloonException
     * @throws ValidationException
     */
    public function route(array $deviceIds, array $groupIds, CarbonImmutable $from, CarbonImmutable $to): Collection
    {
        $this->guardReportArguments(deviceIds: $deviceIds, groupIds: $groupIds, from: $from, to: $to);

        return $this->connector->send(
            request: new GetRouteReport(deviceIds: $deviceIds, groupIds: $groupIds, from: $from, to: $to)
        )->dtoOrFail();
    }

    /**
     * @param  array<int>  $deviceIds
     * @param  array<int>  $groupIds
     * @param  array<string>|null  $types
     *
     * @throws \Saloon\Exceptions\SaloonException
     * @throws ValidationException
     */
    public function events(array $deviceIds, array $groupIds, CarbonImmutable $from, CarbonImmutable $to, ?array $types = null): Collection
    {
        $this->guardReportArguments(deviceIds: $deviceIds, groupIds: $groupIds, from: $from, to: $to);

        return $this->connector->send(
            request: new GetEventsReport(deviceIds: $deviceIds, groupIds: $groupIds, from: $from, to: $to, types: $types)
        )->dtoOrFail();
    }

    /**
     * @param  array<int>  $deviceIds
     * @param  array<int>  $groupIds
     * @param  array<int>|null  $geofenceIds
     *
     * @throws \Saloon\Exceptions\SaloonException
     * @throws ValidationException
     */
    public function geofences(array $deviceIds, array $groupIds, CarbonImmutable $from, CarbonImmutable $to, ?array $geofenceIds = null): Collection
    {
        $this->guardReportArguments(deviceIds: $deviceIds, groupIds: $groupIds, from: $from, to: $to);

        return $this->connector->send(
            request: new GetGeofencesReport(deviceIds: $deviceIds, groupIds: $groupIds, from: $from, to: $to, geofenceIds: $geofenceIds)
        )->dtoOrFail();
    }

    /**
     * @param  array<int>  $deviceIds
     * @param  array<int>  $groupIds
     *
     * @throws \Saloon\Exceptions\SaloonException
     * @throws ValidationException
     */
    public function summary(array $deviceIds, array $groupIds, CarbonImmutable $from, CarbonImmutable $to): Collection
    {
        $this->guardReportArguments(deviceIds: $deviceIds, groupIds: $groupIds, from: $from, to: $to);

        return $this->connector->send(
            request: new GetSummaryReport(deviceIds: $deviceIds, groupIds: $groupIds, from: $from, to: $to)
        )->dtoOrFail();
    }

    /**
     * @param  array<int>  $deviceIds
     * @param  array<int>  $groupIds
     *
     * @throws \Saloon\Exceptions\SaloonException
     * @throws ValidationException
     */
    public function trips(array $deviceIds, array $groupIds, CarbonImmutable $from, CarbonImmutable $to): Collection
    {
        $this->guardReportArguments(deviceIds: $deviceIds, groupIds: $groupIds, from: $from, to: $to);

        return $this->connector->send(
            request: new GetTripsReport(deviceIds: $deviceIds, groupIds: $groupIds, from: $from, to: $to)
        )->dtoOrFail();
    }

    /**
     * @param  array<int>  $deviceIds
     * @param  array<int>  $groupIds
     *
     * @throws \Saloon\Exceptions\SaloonException
     * @throws ValidationException
     */
    public function stops(array $deviceIds, array $groupIds, CarbonImmutable $from, CarbonImmutable $to): Collection
    {
        $this->guardReportArguments(deviceIds: $deviceIds, groupIds: $groupIds, from: $from, to: $to);

        return $this->connector->send(
            request: new GetStopsReport(deviceIds: $deviceIds, groupIds: $groupIds, from: $from, to: $to)
        )->dtoOrFail();
    }

    /**
     * @param  array<int>  $deviceIds
     * @param  array<int>  $groupIds
     *
     * @throws ValidationException
     */
    private function guardReportArguments(array $deviceIds, array $groupIds, CarbonImmutable $from, CarbonImmutable $to): void
    {
        if ($deviceIds === [] && $groupIds === []) {
            throw ValidationException::withMessages([
                'deviceId' => ['At least one device ID or one group ID is required.'],
            ]);
        }

        if ($from->greaterThanOrEqualTo($to)) {
            throw ValidationException::withMessages([
                'from' => ['The from timestamp must be before the to timestamp.'],
            ]);
        }
    }
}
