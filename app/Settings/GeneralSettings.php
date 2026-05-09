<?php

declare(strict_types=1);

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

final class GeneralSettings extends Settings
{
    public string $va_name;

    public string $va_icao;

    public static function group(): string
    {
        return 'default';
    }
}
