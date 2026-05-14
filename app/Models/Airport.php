<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['icao', 'iata', 'name', 'iso_2_country', 'elevation_ft', 'latitude', 'longitude', 'is_hub'])]
final class Airport extends Model
{
    protected function casts(): array
    {
        return [
            'is_hub' => 'boolean',
        ];
    }
}
