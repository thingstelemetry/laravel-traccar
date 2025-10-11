<?php

declare(strict_types=1);

namespace TrackTelemetry\Traccar\Dto;

use TrackTelemetry\Traccar\Enums\SpeedUnit;
use TrackTelemetry\Traccar\Enums\VolumeUnit;
use TrackTelemetry\Traccar\Enums\AltitudeUnit;
use TrackTelemetry\Traccar\Enums\DistanceUnit;

class ServerAttributesData
{
    public function __construct(
        public ?string $language = null,
        public bool   $mapGeofences,
        public ?string $mapLiveRoutes = null,
        public ?string $mapDirection = null,
        public bool   $mapFollow,
        public bool   $mapCluster,
        public bool   $mapOnSelect,
        public ?string $activeMapStyles = null,
        public ?string $devicePrimary = null,
        public ?string $deviceSecondary = null,
        public ?string $soundEvents = null,
        public ?string          $soundAlarms = null,
        public ?string          $positionItems = null,
        public ?string          $googleKey = null,
        public ?string          $locationIqKey = null,
        public ?string          $mapboxAccessToken = null,
        public ?string          $mapTilerKey = null,
        public ?string          $bingMapsKey = null,
        public ?string          $openWeatherKey = null,
        public ?string          $tomTomKey = null,
        public ?string          $hereKey = null,
        public ?string          $notificationTokens = null,
        public bool            $uiDisableSavedCommands,
        public bool            $uiDisableGroups,
        public bool            $uiDisableAttributes,
        public bool            $uiDisableEvents,
        public bool            $uiDisableVehicleFeatures,
        public bool            $uiDisableDrivers,
        public bool            $uiDisableComputedAttributes,
        public bool            $uiDisableCalendars,
        public bool            $uiDisableMaintenance,
        public ?int             $webLiveRouteLength = null,
        public ?float           $mapLineWidth = null,
        public ?float           $mapLineOpacity = null,
        public ?int             $webSelectZoom = null,
        public ?int             $webMaxZoom = null,
        public ?float           $iconScale = null,
        public ?string          $navigationAppLink = null,
        public ?string          $navigationAppTitle = null,
        public SpeedUnit        $speedUnit = SpeedUnit::KNOTS,
        public DistanceUnit   $distanceUnit = DistanceUnit::KILOMETERS,
        public AltitudeUnit    $altitudeUnit = AltitudeUnit::METERS,
        public VolumeUnit      $volumeUnit = VolumeUnit::LITERS,
        public string          $timezone = 'UTC',
    ) {
    }

    public static function fromArray(array $data): self
    {
        $speedUnit = SpeedUnit::tryFrom($data['speedUnit'] ?? '') ?? SpeedUnit::default();
        $distanceUnit = DistanceUnit::tryFrom($data['distanceUnit'] ?? '') ?? DistanceUnit::default();
        $altitudeUnit = AltitudeUnit::tryFrom($data['altitudeUnit'] ?? '') ?? AltitudeUnit::default();
        $volumeUnit = VolumeUnit::tryFrom($data['volumeUnit'] ?? '') ?? VolumeUnit::default();
        $timezone = $data['timezone'] ?? 'UTC';

        return new self(
            language: $data['language'] ?? null,
            mapGeofences: $data['mapGeofences'] ?? false,
            mapLiveRoutes: $data['mapLiveRoutes'] ?? null,
            mapDirection: $data['mapDirection'] ?? null,
            mapFollow: $data['mapFollow'] ?? false,
            mapCluster: $data['mapCluster'] ?? false,
            mapOnSelect: $data['mapOnSelect'] ?? false,
            activeMapStyles: $data['activeMapStyles'] ?? null,
            devicePrimary: $data['devicePrimary'] ?? null,
            deviceSecondary: $data['deviceSecondary'] ?? null,
            soundEvents: $data['soundEvents'] ?? null,
            soundAlarms: $data['soundAlarms'] ?? null,
            positionItems: $data['positionItems'] ?? null,
            googleKey: $data['googleKey'] ?? null,
            locationIqKey: $data['locationIqKey'] ?? null,
            mapboxAccessToken: $data['mapboxAccessToken'] ?? null,
            mapTilerKey: $data['mapTilerKey'] ?? null,
            bingMapsKey: $data['bingMapsKey'] ?? null,
            openWeatherKey: $data['openWeatherKey'] ?? null,
            tomTomKey: $data['tomTomKey'] ?? null,
            hereKey: $data['hereKey'] ?? null,
            notificationTokens: $data['notificationTokens'] ?? null,
            uiDisableSavedCommands: $data['ui.disableSavedCommands'] ?? false,
            uiDisableGroups: $data['ui.disableGroups'] ?? false,
            uiDisableAttributes: $data['ui.disableAttributes'] ?? false,
            uiDisableEvents: $data['ui.disableEvents'] ?? false,
            uiDisableVehicleFeatures: $data['ui.disableVehicleFeatures'] ?? false,
            uiDisableDrivers: $data['ui.disableDrivers'] ?? false,
            uiDisableComputedAttributes: $data['ui.disableComputedAttributes'] ?? false,
            uiDisableCalendars: $data['ui.disableCalendars'] ?? false,
            uiDisableMaintenance: $data['ui.disableMaintenance'] ?? false,
            webLiveRouteLength: $data['web.liveRouteLength'] ?? null,
            mapLineWidth: $data['mapLineWidth'] ?? null,
            mapLineOpacity: $data['mapLineOpacity'] ?? null,
            webSelectZoom: $data['web.selectZoom'] ?? null,
            webMaxZoom: $data['web.maxZoom'] ?? null,
            iconScale: $data['iconScale'] ?? null,
            navigationAppLink: $data['navigationAppLink'] ?? null,
            navigationAppTitle: $data['navigationAppTitle'] ?? null,
            speedUnit: $speedUnit,
            distanceUnit: $distanceUnit,
            altitudeUnit: $altitudeUnit,
            volumeUnit: $volumeUnit,
            timezone: $timezone,
        );
    }

    public function toArray(): array
    {
        return [
            'language'                     => $this->language,
            'mapGeofences'                 => $this->mapGeofences,
            'mapLiveRoutes'                => $this->mapLiveRoutes,
            'mapDirection'                 => $this->mapDirection,
            'mapFollow'                    => $this->mapFollow,
            'mapCluster'                   => $this->mapCluster,
            'mapOnSelect'                  => $this->mapOnSelect,
            'activeMapStyles'              => $this->activeMapStyles,
            'devicePrimary'                => $this->devicePrimary,
            'deviceSecondary'              => $this->deviceSecondary,
            'soundEvents'                  => $this->soundEvents,
            'soundAlarms'                  => $this->soundAlarms,
            'positionItems'                => $this->positionItems,
            'googleKey'                    => $this->googleKey,
            'locationIqKey'                => $this->locationIqKey,
            'mapboxAccessToken'            => $this->mapboxAccessToken,
            'mapTilerKey'                  => $this->mapTilerKey,
            'bingMapsKey'                  => $this->bingMapsKey,
            'openWeatherKey'               => $this->openWeatherKey,
            'tomTomKey'                    => $this->tomTomKey,
            'hereKey'                      => $this->hereKey,
            'notificationTokens'           => $this->notificationTokens,
            'ui.disableSavedCommands'      => $this->uiDisableSavedCommands,
            'ui.disableGroups'             => $this->uiDisableGroups,
            'ui.disableAttributes'         => $this->uiDisableAttributes,
            'ui.disableEvents'             => $this->uiDisableEvents,
            'ui.disableVehicleFeatures'    => $this->uiDisableVehicleFeatures,
            'ui.disableDrivers'            => $this->uiDisableDrivers,
            'ui.disableComputedAttributes' => $this->uiDisableComputedAttributes,
            'ui.disableCalendars'          => $this->uiDisableCalendars,
            'ui.disableMaintenance'        => $this->uiDisableMaintenance,
            'web.liveRouteLength'          => $this->webLiveRouteLength,
            'mapLineWidth'                 => $this->mapLineWidth,
            'mapLineOpacity'               => $this->mapLineOpacity,
            'web.selectZoom'               => $this->webSelectZoom,
            'web.maxZoom'                  => $this->webMaxZoom,
            'iconScale'                    => $this->iconScale,
            'navigationAppLink'            => $this->navigationAppLink,
            'navigationAppTitle'           => $this->navigationAppTitle,
            'speedUnit'                    => $this->speedUnit->value,
            'distanceUnit'                 => $this->distanceUnit->value,
            'altitudeUnit'                 => $this->altitudeUnit->value,
            'volumeUnit'                   => $this->volumeUnit->value,
            'timezone'                     => $this->timezone,
        ];
    }
}
