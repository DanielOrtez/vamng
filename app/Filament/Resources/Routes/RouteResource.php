<?php

declare(strict_types=1);

namespace App\Filament\Resources\Routes;

use App\Filament\Resources\Routes\Pages\CreateRoute;
use App\Filament\Resources\Routes\Pages\EditRoute;
use App\Filament\Resources\Routes\Pages\ListRoutes;
use App\Filament\Resources\Routes\Pages\ViewRoute;
use App\Filament\Resources\Routes\Schemas\RouteForm;
use App\Filament\Resources\Routes\Schemas\RouteInfolist;
use App\Filament\Resources\Routes\Tables\RoutesTable;
use App\Models\Route;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Override;
use UnitEnum;

final class RouteResource extends Resource
{
    protected static ?string $model = Route::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::GlobeAlt;

    protected static string|UnitEnum|null $navigationGroup = 'Airline Management';

    #[Override]
    public static function form(Schema $schema): Schema
    {
        return RouteForm::configure($schema);
    }

    #[Override]
    public static function infolist(Schema $schema): Schema
    {
        return RouteInfolist::configure($schema);
    }

    #[Override]
    public static function table(Table $table): Table
    {
        return RoutesTable::configure($table);
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
            'index' => ListRoutes::route('/'),
            'create' => CreateRoute::route('/create'),
            'view' => ViewRoute::route('/{record}'),
            'edit' => EditRoute::route('/{record}/edit'),
        ];
    }
}
