<?php

declare(strict_types=1);

namespace App\Models;

use App\EloquentBuilder\AirportBuilder;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Override;

#[Fillable(['icao', 'iata', 'name', 'iso_2_country', 'elevation_ft', 'latitude', 'longitude', 'is_hub'])]
final class Airport extends Model
{
    public function newEloquentBuilder($query): Builder
    {
        return new AirportBuilder($query);
    }

    /**
     * @return HasMany<Route, $this>
     */
    public function departureRoutes(): HasMany
    {
        return $this->hasMany(Route::class, 'departure_airport_id');
    }

    #[Override]
    protected function casts(): array
    {
        return [
            'is_hub' => 'boolean',
        ];
    }
}
