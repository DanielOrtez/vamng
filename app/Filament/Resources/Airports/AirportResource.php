<?php

declare(strict_types=1);

namespace App\Filament\Resources\Airports;

use App\Filament\Resources\Airports\Pages\CreateAirport;
use App\Filament\Resources\Airports\Pages\EditAirport;
use App\Filament\Resources\Airports\Pages\ListAirports;
use App\Filament\Resources\Airports\Schemas\AirportForm;
use App\Filament\Resources\Airports\Tables\AirportsTable;
use App\Models\Airport;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Override;
use UnitEnum;

final class AirportResource extends Resource
{
    protected static ?string $model = Airport::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::GlobeEuropeAfrica;

    protected static string|UnitEnum|null $navigationGroup = 'Airline Management';

    #[Override]
    public static function form(Schema $schema): Schema
    {
        return AirportForm::configure($schema);
    }

    #[Override]
    public static function table(Table $table): Table
    {
        return AirportsTable::configure($table);
    }

    #[Override]
    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    #[Override]
    public static function getPages(): array
    {
        return [
            'index' => ListAirports::route('/'),
            'create' => CreateAirport::route('/create'),
            'edit' => EditAirport::route('/{record}/edit'),
        ];
    }
}
