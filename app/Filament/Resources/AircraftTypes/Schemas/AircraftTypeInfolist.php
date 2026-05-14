<?php

declare(strict_types=1);

namespace App\Filament\Resources\AircraftTypes\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

final class AircraftTypeInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(3)
                    ->schema([
                        TextEntry::make('type')
                            ->label('Aircraft Type'),
                        TextEntry::make('icao')
                            ->label('Aircraft ICAO'),
                        TextEntry::make('range_nm')
                            ->label('Range (nm)'),
                        TextEntry::make('pax_capacity')
                            ->label('Pax Capacity'),
                        TextEntry::make('cargo_capacity')
                            ->label('Cargo Capacity'),
                        TextEntry::make('aircrafts_count')
                            ->counts('aircrafts')
                            ->label('Aircraft Count'),
                    ])->columnSpanFull(),
                TextEntry::make('image_url')
                    ->default('None')
                    ->badge(fn (string $state): bool => $state === 'None')
                    ->color(fn (string $state): string => match ($state) {
                        'None' => 'danger',
                        default => '',
                    })
                    ->columnSpanFull()
                    ->label('Image URL'),
            ]);
    }
}
