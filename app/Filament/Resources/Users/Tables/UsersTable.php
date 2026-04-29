<?php

declare(strict_types=1);

namespace App\Filament\Resources\Users\Tables;

use Carbon\CarbonImmutable;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

final class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->label('Email Address')
                    ->searchable(),
                IconColumn::make('email_verified_at')
                    ->boolean()
                    ->default(false)
                    ->tooltip(fn (CarbonImmutable|false $state): string => $state ? $state->format('Y-F-d') : 'Not verified')
                    ->sortable()
                    ->label('Verified'),
                TextColumn::make('roles.name')
                    ->default('None')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'None' => 'danger',
                        default => 'gray'
                    })
                    ->searchable()
                    ->label('Roles'),
                TextColumn::make('created_at')
                    ->date('Y-F-d')
                    ->sortable()
                    ->label('Created At'),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
