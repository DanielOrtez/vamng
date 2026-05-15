<?php

declare(strict_types=1);

namespace App\Filament\Resources\Airports\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Squire\Models\Country;

final class AirportsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('icao')
                    ->searchable()
                    ->label('ICAO'),
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('iso_2_country')
                    ->sortable()
                    ->formatStateUsing(fn (mixed $state): string => Country::find($state)->name ?? $state)
                    ->label('Country'),
                IconColumn::make('is_hub')
                    ->boolean()
                    ->sortable()
                    ->label('Is Hub?'),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
