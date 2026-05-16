<?php

declare(strict_types=1);

namespace App\Filament\Resources\AircraftTypes\Pages;

use App\Filament\Resources\AircraftTypes\AircraftTypeResource;
use Filament\Resources\Pages\CreateRecord;

final class CreateAircraftType extends CreateRecord
{
    protected static string $resource = AircraftTypeResource::class;
}
