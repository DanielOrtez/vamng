<?php

declare(strict_types=1);

namespace App\Filament\Resources\Airports\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Squire\Models\Country;

final class AirportForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('icao_code')
                    ->required()
                    ->maxLength(4)
                    ->label('ICAO'),
                TextInput::make('iata_code')
                    ->maxLength(3)
                    ->label('IATA'),
                TextInput::make('name')
                    ->columnSpanFull()
                    ->required()
                    ->maxLength(255),
                Select::make('iso_country')
                    ->options(Country::all()->pluck('name', 'code_2'))
                    ->searchable()
                    ->required()
                    ->label('Country'),
                TextInput::make('elevation_ft')
                    ->integer()
                    ->required(),
                TextInput::make('latitude')
                    ->numeric()
                    ->step(0.000001)
                    ->required(),
                TextInput::make('longitude')
                    ->numeric()
                    ->step(0.000001)
                    ->required(),
            ]);
    }
}
