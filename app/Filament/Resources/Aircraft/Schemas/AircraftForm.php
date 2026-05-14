<?php

declare(strict_types=1);

namespace App\Filament\Resources\Aircraft\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;

final class AircraftForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('registration')
                    ->required(),
                TextInput::make('name'),
                Select::make('aircraft_type_id')
                    ->relationship('aircraftType', 'icao')
                    ->preload()
                    ->searchable()
                    ->required(),
                Select::make('hub_id')
                    ->relationship('hub', 'name', fn (Builder $query): Builder => $query->where('is_hub', true))
                    ->preload()
                    ->searchable()
                    ->required(),
                Select::make('curr_location_id')
                    ->relationship('currLocation', 'icao')
                    ->preload()
                    ->searchable()
                    ->hiddenOn('create')
                    ->required()
                    ->label('Current Location'),
            ]);
    }
}
