<?php

declare(strict_types=1);

namespace App\Filament\Resources\Airports\Pages;

use App\Filament\Resources\Airports\AirportResource;
use App\Filament\Resources\Airports\Utils\AirportUtils;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Override;

final class EditAirport extends EditRecord
{
    protected static string $resource = AirportResource::class;

    #[Override]
    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['latitude'] = $data['location']->getLatitude();
        $data['longitude'] = $data['location']->getLongitude();

        unset($data['location']);

        return $data;
    }

    #[Override]
    protected function mutateFormDataBeforeSave(array $data): array
    {
        return AirportUtils::convertLatLonToPoint($data);
    }

    #[Override]
    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
