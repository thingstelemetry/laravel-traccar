<?php

declare(strict_types=1);

namespace TrackTelemetry\Traccar\Dto;

use TrackTelemetry\Traccar\Enums\SpeedUnit;
use TrackTelemetry\Traccar\Enums\VolumeUnit;
use TrackTelemetry\Traccar\Enums\AltitudeUnit;
use TrackTelemetry\Traccar\Enums\DistanceUnit;

class ServerAttributes
{
    public function __construct(
        public ?string $language = null,
        public ?bool   $mapGeofences = null,
        public ?string $mapLiveRoutes = null,
        public ?string $mapDirection = null,
        public ?bool   $mapFollow = null,
        public ?bool   $mapCluster = null,
        public ?bool   $mapOnSelect = null,
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
        public ?bool            $uiDisableSavedCommands = null,
        public ?bool            $uiDisableGroups = null,
        public ?bool            $uiDisableAttributes = null,
        public ?bool            $uiDisableEvents = null,
        public ?bool            $uiDisableVehicleFeatures = null,
        public ?bool            $uiDisableDrivers = null,
        public ?bool            $uiDisableComputedAttributes = null,
        public ?bool            $uiDisableCalendars = null,
        public ?bool            $uiDisableMaintenance = null,
        public ?int             $webLiveRouteLength = null,
        public ?float           $mapLineWidth = null,
        public ?float           $mapLineOpacity = null,
        public ?int             $webSelectZoom = null,
        public ?int             $webMaxZoom = null,
        public ?float           $iconScale = null,
        public ?string          $navigationAppLink = null,
        public ?string          $navigationAppTitle = null,

        // Units & Time
        public SpeedUnit        $speedUnit = SpeedUnit::KNOTS,
        public DistanceUnit   $distanceUnit = DistanceUnit::KILOMETERS,
        public AltitudeUnit    $altitudeUnit = AltitudeUnit::METERS,
        public VolumeUnit      $volumeUnit = VolumeUnit::LITERS,
        public string          $timezone = 'UTC',

        // Any unrecognized attributes
        public array            $others = [],
    ) {
    }

    public static function fromArray(array $data): self
    {
        $speedUnit = SpeedUnit::tryFrom($data['speedUnit'] ?? '') ?? SpeedUnit::default();
        $distanceUnit = DistanceUnit::tryFrom($data['distanceUnit'] ?? '') ?? DistanceUnit::default();
        $altitudeUnit = AltitudeUnit::tryFrom($data['altitudeUnit'] ?? '') ?? AltitudeUnit::default();
        $volumeUnit = VolumeUnit::tryFrom($data['volumeUnit'] ?? '') ?? VolumeUnit::default();
        $timezone = $data['timezone'] ?? 'UTC';

        $knownKeys = [
            'language', 'mapGeofences', 'mapLiveRoutes', 'mapDirection', 'mapFollow',
            'mapCluster', 'mapOnSelect', 'activeMapStyles', 'devicePrimary', 'deviceSecondary',
            'soundEvents', 'soundAlarms', 'positionItems', 'googleKey', 'locationIqKey',
            'mapboxAccessToken', 'mapTilerKey', 'bingMapsKey', 'openWeatherKey', 'tomTomKey',
            'hereKey', 'notificationTokens', 'ui.disableSavedCommands', 'ui.disableGroups',
            'ui.disableAttributes', 'ui.disableEvents', 'ui.disableVehicleFeatures', 'ui.disableDrivers',
            'ui.disableComputedAttributes', 'ui.disableCalendars', 'ui.disableMaintenance',
            'web.liveRouteLength', 'mapLineWidth', 'mapLineOpacity', 'web.selectZoom', 'web.maxZoom',
            'iconScale', 'navigationAppLink', 'navigationAppTitle',
            'speedUnit', 'distanceUnit', 'altitudeUnit', 'volumeUnit', 'timezone',
        ];

        $others = array_diff_key($data, array_flip($knownKeys));

        return new self(
            language: $data['language'] ?? null,
            mapGeofences: $data['mapGeofences'] ?? null,
            mapLiveRoutes: $data['mapLiveRoutes'] ?? null,
            mapDirection: $data['mapDirection'] ?? null,
            mapFollow: $data['mapFollow'] ?? null,
            mapCluster: $data['mapCluster'] ?? null,
            mapOnSelect: $data['mapOnSelect'] ?? null,
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
            uiDisableSavedCommands: $data['ui.disableSavedCommands'] ?? null,
            uiDisableGroups: $data['ui.disableGroups'] ?? null,
            uiDisableAttributes: $data['ui.disableAttributes'] ?? null,
            uiDisableEvents: $data['ui.disableEvents'] ?? null,
            uiDisableVehicleFeatures: $data['ui.disableVehicleFeatures'] ?? null,
            uiDisableDrivers: $data['ui.disableDrivers'] ?? null,
            uiDisableComputedAttributes: $data['ui.disableComputedAttributes'] ?? null,
            uiDisableCalendars: $data['ui.disableCalendars'] ?? null,
            uiDisableMaintenance: $data['ui.disableMaintenance'] ?? null,
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
            others: $others,
        );
    }

    public function toArray(): array
    {
        return array_merge([
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
        ], $this->others);
    }
}
