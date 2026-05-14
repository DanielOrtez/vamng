<?php

declare(strict_types=1);

namespace App\Filament\Resources\Aircraft\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

final class AircraftInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(3)
                    ->schema([
                        TextEntry::make('aircraftType.icao')
                            ->label('Aircraft ICAO'),
                        TextEntry::make('registration'),
                        TextEntry::make('hours_flown'),
                    ])->columnSpanFull(),
                TextEntry::make('name')
                    ->columnSpanFull()
                    ->default('None')
                    ->badge(fn (string $state): bool => $state === 'None')
                    ->color(fn (string $state): string => match ($state) {
                        'None' => 'danger',
                        default => '',
                    })
                    ->label('Aircraft Name'),
                TextEntry::make('hub')
                    ->formatStateUsing(fn (mixed $state): string => "{$state->name} ({$state->icao})")
                    ->label('Aircraft Hub'),
                TextEntry::make('currLocation')
                    ->formatStateUsing(fn (mixed $state): string => "{$state->name} ({$state->icao})")
                    ->label('Aircraft Current Location'),
            ]);
    }
}
