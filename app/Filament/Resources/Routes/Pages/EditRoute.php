<?php

declare(strict_types=1);

namespace App\Filament\Resources\Routes\Pages;

use App\Filament\Resources\Routes\RouteResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Override;

final class EditRoute extends EditRecord
{
    protected static string $resource = RouteResource::class;

    #[Override]
    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
