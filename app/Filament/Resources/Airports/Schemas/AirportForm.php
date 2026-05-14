<?php

declare(strict_types=1);

namespace App\Filament\Resources\Airports\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;
use Squire\Models\Country;

final class AirportForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('icao')
                    ->required()
                    ->maxLength(4)
                    ->label('ICAO'),
                TextInput::make('iata')
                    ->maxLength(3)
                    ->label('IATA'),
                TextInput::make('name')
                    ->columnSpanFull()
                    ->required()
                    ->maxLength(255),
                Select::make('iso_2_country')
                    ->options(Country::all()->pluck('name', 'code_2'))
                    ->searchable()
                    ->required()
                    ->label('Country'),
                TextInput::make('elevation_ft')
                    ->integer()
                    ->required(),
                Grid::make(3)
                    ->schema([
                        TextInput::make('latitude')
                            ->numeric()
                            ->step(0.000001)
                            ->required(),
                        TextInput::make('longitude')
                            ->numeric()
                            ->step(0.000001)
                            ->required(),
                        Toggle::make('is_hub')
                            ->inline(false)
                            ->extraAttributes(['style' => 'margin-top: .3rem;'])
                            ->label('Is Hub?'),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
