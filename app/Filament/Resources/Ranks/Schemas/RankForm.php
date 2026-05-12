<?php

declare(strict_types=1);

namespace App\Filament\Resources\Ranks\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

final class RankForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('hours')
                    ->required()
                    ->numeric()
                    ->label('Hours Required'),
                TextInput::make('image_url')
                    ->url()
                    ->columnSpanFull()
                    ->label('Image URL'),
            ]);
    }
}
