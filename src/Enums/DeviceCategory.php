<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Enums;

enum DeviceCategory: string
{
    case DEFAULT = 'default';
    case ANIMAL = 'animal';
    case BICYCLE = 'bicycle';
    case BOAT = 'boat';
    case BUS = 'bus';
    case CAR = 'car';
    case CAMPER = 'camper';
    case CRANE = 'crane';
    case HELICOPTER = 'helicopter';
    case MOTORCYCLE = 'motorcycle';
    case PERSON = 'person';
    case PLANE = 'plane';
    case SHIP = 'ship';
    case TRACTOR = 'tractor';
    case TRAILER = 'trailer';
    case TRAIN = 'train';
    case TRAM = 'tram';
    case TRUCK = 'truck';
    case VAN = 'van';
    case SCOOTER = 'scooter';

    public static function default(): self
    {
        return self::DEFAULT;
    }

    public function label(): string
    {
        return match ($this) {
            self::DEFAULT    => 'Default',
            self::ANIMAL     => 'Animal',
            self::BICYCLE    => 'Bicycle',
            self::BOAT       => 'Boat',
            self::BUS        => 'Bus',
            self::CAR        => 'Car',
            self::CAMPER     => 'Camper',
            self::CRANE      => 'Crane',
            self::HELICOPTER => 'Helicopter',
            self::MOTORCYCLE => 'Motorcycle',
            self::PERSON     => 'Person',
            self::PLANE      => 'Plane',
            self::SHIP       => 'Ship',
            self::TRACTOR    => 'Tractor',
            self::TRAILER    => 'Trailer',
            self::TRAIN      => 'Train',
            self::TRAM       => 'Tram',
            self::TRUCK      => 'Truck',
            self::VAN        => 'Van',
            self::SCOOTER    => 'Scooter',
        };
    }
}
