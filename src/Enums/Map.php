<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Enums;

enum Map: string
{
    case OPEN_FREE_MAP = 'openFreeMap';
    case LOCATION_IQ_STREETS = 'locationIqStreets';
    case LOCATION_IQ_DARK = 'locationIqDark';
    case OSM = 'osm';
    case OPEN_TOPO_MAP = 'openTopoMap';
    case CARTO = 'carto';
    case GOOGLE_ROAD = 'googleRoad';
    case GOOGLE_SATELLITE = 'googleSatellite';
    case GOOGLE_HYBRID = 'googleHybrid';
    case AUTO_NAVI = 'autoNavi';
    case ORDNANCE_SURVEY = 'ordnanceSurvey';

    public static function default(): self
    {
        return self::LOCATION_IQ_STREETS;
    }

    public function label(): string
    {
        return match($this) {
            self::OPEN_FREE_MAP       => 'OpenFreeMap',
            self::LOCATION_IQ_STREETS => 'LocationIQ Streets',
            self::LOCATION_IQ_DARK    => 'LocationIQ Dark',
            self::OSM                 => 'OpenStreetMap',
            self::OPEN_TOPO_MAP       => 'OpenTopoMap',
            self::CARTO               => 'Carto Basemaps',
            self::GOOGLE_ROAD         => 'Google Road',
            self::GOOGLE_SATELLITE    => 'Google Satellite',
            self::GOOGLE_HYBRID       => 'Google Hybrid',
            self::AUTO_NAVI           => 'AutoNavi',
            self::ORDNANCE_SURVEY     => 'Ordnance Survey',
        };
    }
}
