<?php

declare(strict_types=1);

namespace App\Filament\Resources\AircraftTypes\Pages;

use App\Filament\Resources\AircraftTypes\AircraftTypeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Override;

final class ListAircraftTypes extends ListRecords
{
    protected static string $resource = AircraftTypeResource::class;

    #[Override]
    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
