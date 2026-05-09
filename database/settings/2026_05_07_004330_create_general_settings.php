<?php

declare(strict_types=1);

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('default.va_name', 'VAMng');
        $this->migrator->add('default.va_icao', 'VAM');
    }
};
