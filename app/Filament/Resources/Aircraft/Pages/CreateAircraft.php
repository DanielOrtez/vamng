<?php

declare(strict_types=1);

namespace App\Filament\Resources\Aircraft\Pages;

use App\Filament\Resources\Aircraft\AircraftResource;
use Filament\Resources\Pages\CreateRecord;
use Override;

final class CreateAircraft extends CreateRecord
{
    protected static string $resource = AircraftResource::class;

    #[Override]
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['curr_location_id'] = $data['hub_id'];

        return $data;
    }
}
