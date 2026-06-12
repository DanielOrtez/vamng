<?php

declare(strict_types=1);

namespace App\Filament\Resources\Airports\Pages;

use App\Filament\Resources\Airports\AirportResource;
use App\Filament\Resources\Airports\Utils\AirportUtils;
use Filament\Resources\Pages\CreateRecord;
use Override;

final class CreateAirport extends CreateRecord
{
    protected static string $resource = AirportResource::class;

    #[Override]
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        return AirportUtils::convertLatLonToPoint($data);
    }
}
