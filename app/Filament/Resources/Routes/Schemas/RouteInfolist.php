<?php

declare(strict_types=1);

namespace App\Filament\Resources\Routes\Schemas;

use Filament\Infolists\Components\TextEntry;
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
                    ->label('Departure airport'),
                TextEntry::make('arrivalAirport')
                    ->formatStateUsing(fn (mixed $state): string => sprintf('%s (%s)', $state->name, $state->icao))
                    ->label('Arrival airport'),
                TextEntry::make('distance')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('route')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('departure_time')
                    ->time('H:i')
                    ->placeholder('-'),
                TextEntry::make('arrival_time')
                    ->time('H:i')
                    ->placeholder('-'),
                TextEntry::make('flight_time')
                    ->time('H:i')
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
