<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Override;

#[Fillable(['icao', 'iata', 'name', 'iso_2_country', 'elevation_ft', 'latitude', 'longitude', 'is_hub'])]
final class Airport extends Model
{
    /**
     * @param  Builder<Airport>  $query
     */
    #[Scope]
    protected function hubs(Builder $query): void
    {
        $query->where('is_hub', true);
    }

    #[Override]
    protected function casts(): array
    {
        return [
            'is_hub' => 'boolean',
        ];
    }
}
