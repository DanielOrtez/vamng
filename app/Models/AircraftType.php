<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\AircraftTypeEnum;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['type', 'icao', 'range_nm', 'pax_capacity', 'cargo_capacity', 'image_url'])]
final class AircraftType extends Model
{
    /**
     * @return HasMany<Aircraft, $this>
     */
    public function aircrafts(): HasMany
    {
        return $this->hasMany(Aircraft::class);
    }

    protected function casts(): array
    {
        return [
            'type' => AircraftTypeEnum::class,
        ];
    }
}
