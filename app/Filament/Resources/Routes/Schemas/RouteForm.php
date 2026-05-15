<?php

declare(strict_types=1);

namespace App\Filament\Resources\Routes\Schemas;

use App\Enums\RouteTypeEnum;
use App\Settings\GeneralSettings;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Components\Text;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;

final class RouteForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('type')
                    ->options(RouteTypeEnum::class)
                    ->required()
                    ->label('Route Type'),
                Select::make('aircraftTypes')
                    ->multiple()
                    ->relationship(titleAttribute: 'icao')
                    ->preload()
                    ->required()
                    ->label('Aircraft Types')
                    ->afterLabel(Text::make('e.g., A320')->weight(FontWeight::Bold)),
                Select::make('departure_airport_id')
                    ->relationship('departureAirport', 'name')
                    ->preload()
                    ->searchable()
                    ->required()
                    ->label('Departure Airport'),
                Select::make('arrival_airport_id')
                    ->relationship('arrivalAirport', 'name')
                    ->preload()
                    ->searchable()
                    ->required()
                    ->label('Arrival Airport'),
                TextInput::make('code')
                    ->alphaNum()
                    ->required()
                    ->prefix(app(GeneralSettings::class)->va_icao)
                    ->label('Route Code')
                    ->afterLabel(
                        Text::make('Only Code. e.g., 001')
                            ->weight(FontWeight::Bold)
                    ),
                TextInput::make('distance')
                    ->numeric()
                    ->label('Distance (nm)'),
                Textarea::make('route')
                    ->columnSpanFull(),
                TimePicker::make('departure_time')
                    ->seconds(false)
                    ->required()
                    ->label('Departure Time'),
                TimePicker::make('arrival_time')
                    ->seconds(false)
                    ->required()
                    ->label('Arrival Time'),
                TimePicker::make('flight_time')
                    ->seconds(false)
                    ->label('Flight Time'),
                TextInput::make('cost_index')
                    ->numeric()
                    ->minValue(0)
                    ->label('Cost Index'),
            ]);
    }
}
