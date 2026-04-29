<?php

declare(strict_types=1);

namespace App\Filament\Resources\Users\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

final class UserInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name'),
                TextEntry::make('email')
                    ->label('Email Address'),
                TextEntry::make('email_verified_at')
                    ->date('Y-F-d')
                    ->placeholder('Not verified yet.')
                    ->label('Email Verified At'),
                TextEntry::make('roles.name')
                    ->placeholder('No roles assigned.')
                    ->badge()
                    ->label('Roles'),
                TextEntry::make('created_at')
                    ->date('Y-F-d')
                    ->placeholder('-')
                    ->label('Created At'),
                TextEntry::make('updated_at')
                    ->date('Y-F-d')
                    ->placeholder('-')
                    ->label('Updated At'),
            ]);
    }
}
