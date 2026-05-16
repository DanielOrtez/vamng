<?php

declare(strict_types=1);

namespace App\Filament\Resources\AircraftTypes\Pages;

use App\Filament\Resources\AircraftTypes\AircraftTypeResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Override;

final class ViewAircraftType extends ViewRecord
{
    protected static string $resource = AircraftTypeResource::class;

    #[Override]
    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
