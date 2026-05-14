<?php

declare(strict_types=1);

namespace App\Filament\Resources\AircraftTypes;

use App\Filament\Resources\AircraftTypes\Pages\CreateAircraftType;
use App\Filament\Resources\AircraftTypes\Pages\EditAircraftType;
use App\Filament\Resources\AircraftTypes\Pages\ListAircraftTypes;
use App\Filament\Resources\AircraftTypes\Pages\ViewAircraftType;
use App\Filament\Resources\AircraftTypes\RelationManagers\AircraftsRelationManager;
use App\Filament\Resources\AircraftTypes\Schemas\AircraftTypeForm;
use App\Filament\Resources\AircraftTypes\Schemas\AircraftTypeInfolist;
use App\Filament\Resources\AircraftTypes\Tables\AircraftTypesTable;
use App\Models\AircraftType;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

final class AircraftTypeResource extends Resource
{
    protected static ?string $model = AircraftType::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::PaperAirplane;

    protected static string|UnitEnum|null $navigationGroup = 'Fleet Management';

    public static function form(Schema $schema): Schema
    {
        return AircraftTypeForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return AircraftTypeInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AircraftTypesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            AircraftsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAircraftTypes::route('/'),
            'create' => CreateAircraftType::route('/create'),
            'view' => ViewAircraftType::route('/{record}'),
            'edit' => EditAircraftType::route('/{record}/edit'),
        ];
    }
}
