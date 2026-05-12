<?php

declare(strict_types=1);

namespace App\Filament\Resources\Ranks\Pages;

use App\Filament\Resources\Ranks\RankResource;
use Filament\Resources\Pages\CreateRecord;

final class CreateRank extends CreateRecord
{
    protected static string $resource = RankResource::class;
}
