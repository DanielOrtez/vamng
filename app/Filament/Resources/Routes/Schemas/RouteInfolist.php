<?php

declare(strict_types=1);

namespace App\Filament\Resources\Routes\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

final class RouteInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('type'),
                TextEntry::make('routeCode')
                    ->label('Route Code'),
                TextEntry::make('departureAirport')
                    ->formatStateUsing(fn (mixed $state): string => sprintf('%s (%s)', $state->name, $state->icao))
                    ->label('Departure Airport'),
                TextEntry::make('arrivalAirport')
                    ->formatStateUsing(fn (mixed $state): string => sprintf('%s (%s)', $state->name, $state->icao))
                    ->label('Arrival Airport'),
                Grid::make(3)
                    ->schema([
                        TextEntry::make('distance')
                            ->numeric()
                            ->placeholder('-'),
                        TextEntry::make('departure_time')
                            ->time('H:i')
                            ->placeholder('-'),
                        TextEntry::make('arrival_time')
                            ->time('H:i')
                            ->placeholder('-'),
                    ])->columnSpanFull(),
                TextEntry::make('route')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('flight_time_formatted')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('cost_index')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->date('Y-F-d')
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime('Y-F-d H:i')
                    ->placeholder('-'),
            ]);
    }
}
