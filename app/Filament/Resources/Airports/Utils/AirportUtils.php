<?php

declare(strict_types=1);

namespace App\Filament\Resources\Airports\Utils;

use Clickbar\Magellan\Data\Geometries\Point;

final class AirportUtils
{
    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    public static function convertLatLonToPoint(array $data): array
    {
        $data['location'] = Point::makeGeodetic($data['latitude'], $data['longitude']);

        unset($data['longitude'], $data['latitude']);

        return $data;
    }
}
