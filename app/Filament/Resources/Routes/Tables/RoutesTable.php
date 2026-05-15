<?php

declare(strict_types=1);

namespace App\Filament\Resources\Routes\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

final class RoutesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('routeCode')
                    ->searchable('code')
                    ->label('Route Code'),
                TextColumn::make('type')
                    ->sortable()
                    ->label('Route Type'),
                TextColumn::make('departureAirport.icao')
                    ->searchable()
                    ->label('Departure Airport'),
                TextColumn::make('arrivalAirport.icao')
                    ->searchable()
                    ->label('Arrival Airport'),
                TextColumn::make('flight_time')
                    ->time('H:i')
                    ->sortable()
                    ->label('Flight Time'),
                TextColumn::make('cost_index')
                    ->label('Cost Index'),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
