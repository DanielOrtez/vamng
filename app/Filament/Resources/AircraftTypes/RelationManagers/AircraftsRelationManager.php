<?php

declare(strict_types=1);

namespace App\Filament\Resources\AircraftTypes\RelationManagers;

use App\Filament\Resources\AircraftTypes\AircraftTypeResource;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

final class AircraftsRelationManager extends RelationManager
{
    protected static string $relationship = 'aircrafts';

    protected static ?string $title = 'Aircrafts';

    protected static ?string $relatedResource = AircraftTypeResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('registration')
                    ->disabledClick()
                    ->searchable(),
                TextColumn::make('name')
                    ->searchable()
                    ->disabledClick(),
                TextColumn::make('hours_flown')
                    ->disabledClick(),
            ])
            ->recordActions([]);
    }
}
