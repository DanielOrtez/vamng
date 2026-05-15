<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum RouteTypeEnum: string implements HasLabel
{
    case SCHEDULED = 'sd';
    case CARGO = 'cr';

    public function getLabel(): string
    {
        return match ($this) {
            self::SCHEDULED => 'Scheduled Passenger',
            self::CARGO => 'Cargo',
        };
    }
}
