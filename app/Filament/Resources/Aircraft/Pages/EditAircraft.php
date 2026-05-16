<?php

declare(strict_types=1);

namespace App\Filament\Resources\Aircraft\Pages;

use App\Filament\Resources\Aircraft\AircraftResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Override;

final class EditAircraft extends EditRecord
{
    protected static string $resource = AircraftResource::class;

    #[Override]
    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
