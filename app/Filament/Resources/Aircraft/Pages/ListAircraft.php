<?php

declare(strict_types=1);

namespace App\Filament\Resources\Aircraft\Pages;

use App\Filament\Resources\Aircraft\AircraftResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Override;

final class ListAircraft extends ListRecords
{
    protected static string $resource = AircraftResource::class;

    #[Override]
    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
