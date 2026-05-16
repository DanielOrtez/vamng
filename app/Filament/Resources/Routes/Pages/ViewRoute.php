<?php

declare(strict_types=1);

namespace App\Filament\Resources\Routes\Pages;

use App\Filament\Resources\Routes\RouteResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Override;

final class ViewRoute extends ViewRecord
{
    protected static string $resource = RouteResource::class;

    #[Override]
    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
