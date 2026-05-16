<?php

declare(strict_types=1);

namespace App\Filament\Resources\AircraftTypes\Pages;

use App\Filament\Resources\AircraftTypes\AircraftTypeResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Override;

final class EditAircraftType extends EditRecord
{
    protected static string $resource = AircraftTypeResource::class;

    #[Override]
    public function getRelationManagers(): array
    {
        return [];
    }

    #[Override]
    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
