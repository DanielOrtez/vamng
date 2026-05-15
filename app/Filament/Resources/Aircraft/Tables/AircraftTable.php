<?php

declare(strict_types=1);

namespace App\Filament\Resources\Aircraft\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

final class AircraftTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('aircraftType.icao')
                    ->searchable()
                    ->label('Aircraft ICAO'),
                TextColumn::make('registration')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('name')
                    ->limit(30),
                TextColumn::make('hours_flown')
                    ->label('Hours Flown'),
                TextColumn::make('hub.icao')
                    ->searchable(),
                TextColumn::make('currLocation.icao')
                    ->label('Location'),
            ])
            ->filters([
                //
            ])
            ->recordActions([
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
