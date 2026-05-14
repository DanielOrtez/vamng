<?php

declare(strict_types=1);

namespace App\Filament\Pages;

use App\Models\Rank;
use App\Settings\GeneralSettings;
use BackedEnum;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Pages\SettingsPage;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Override;
use UnitEnum;

final class ManageSettings extends SettingsPage
{
    use HasPageShield;

    protected static ?string $navigationLabel = 'VA Settings';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static string|UnitEnum|null $navigationGroup = 'Administration';

    protected static string $settings = GeneralSettings::class;

    #[Override]
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('va_name')
                    ->required()
                    ->label('Virtual Airline Name'),
                TextInput::make('va_icao')
                    ->length(3)
                    ->autocapitalize()
                    ->required()
                    ->label('Virtual Airline ICAO'),
                Select::make('va_default_rank')
                    ->options(Rank::query()->pluck('name', 'id'))
                    ->preload()
                    ->searchable()
                    ->required()
                    ->label('Default Rank'),
            ]);
    }
}
