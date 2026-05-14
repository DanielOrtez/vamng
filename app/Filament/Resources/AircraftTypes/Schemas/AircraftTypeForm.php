<?php

declare(strict_types=1);

namespace App\Filament\Resources\AircraftTypes\Schemas;

use App\Enums\AircraftTypeEnum;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Text;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;

final class AircraftTypeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(3)
                    ->schema([
                        Select::make('type')
                            ->reactive()
                            ->options(AircraftTypeEnum::class)
                            ->required(),
                        TextInput::make('icao')
                            ->alphaNum()
                            ->maxLength(4)
                            ->required()
                            ->label('Aircraft ICAO')
                            ->afterLabel(Text::make('e.g., A320')->weight(FontWeight::Bold)),
                        TextInput::make('range_nm')
                            ->numeric()
                            ->minValue(0)
                            ->label('Range (nm)'),
                    ])->columnSpanFull(),
                TextInput::make('pax_capacity')
                    ->numeric()
                    ->minValue(0)
                    ->disabled(fn (callable $get): bool => $get('type') === AircraftTypeEnum::CARGO),
                TextInput::make('cargo_capacity')
                    ->numeric()
                    ->minValue(0),
                TextInput::make('image_url')
                    ->url()
                    ->columnSpanFull(),
            ]);
    }
}
