<?php

declare(strict_types=1);

namespace App\Filament\Resources\Aircraft;

use App\Filament\Resources\Aircraft\Pages\CreateAircraft;
use App\Filament\Resources\Aircraft\Pages\EditAircraft;
use App\Filament\Resources\Aircraft\Pages\ListAircraft;
use App\Filament\Resources\Aircraft\Pages\ViewAircraft;
use App\Filament\Resources\Aircraft\Schemas\AircraftForm;
use App\Filament\Resources\Aircraft\Schemas\AircraftInfolist;
use App\Filament\Resources\Aircraft\Tables\AircraftTable;
use App\Models\Aircraft;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

final class AircraftResource extends Resource
{
    protected static ?string $model = Aircraft::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::CircleStack;

    protected static string|UnitEnum|null $navigationGroup = 'Fleet Management';

    protected static ?string $navigationLabel = 'Aircrafts';

    public static function form(Schema $schema): Schema
    {
        return AircraftForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return AircraftInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AircraftTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAircraft::route('/'),
            'create' => CreateAircraft::route('/create'),
            'view' => ViewAircraft::route('/{record}'),
            'edit' => EditAircraft::route('/{record}/edit'),
        ];
    }
}
