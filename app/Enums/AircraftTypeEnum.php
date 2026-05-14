<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum AircraftTypeEnum: string implements HasLabel
{
    case PASSENGER = 'p';
    case CARGO = 'c';
    case MIXED = 'm';

    public function getLabel(): string
    {
        return match ($this) {
            self::PASSENGER => 'Passenger',
            self::CARGO => 'Cargo',
            self::MIXED => 'Mixed',
        };
    }
}
