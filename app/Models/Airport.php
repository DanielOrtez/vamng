<?php

declare(strict_types=1);

namespace App\Models;

use App\EloquentBuilder\AirportBuilder;
use Clickbar\Magellan\Data\Geometries\Point;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Override;
use Squire\Models\Country;

#[Fillable(['icao', 'iata', 'name', 'iso_2_country', 'elevation_ft', 'location', 'is_hub'])]
final class Airport extends Model
{
    #[Override]
    public function newEloquentBuilder($query): AirportBuilder
    {
        return new AirportBuilder($query);
    }

    /**
     * @return BelongsTo<Country, $this>
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'iso_2_country', 'code_2');
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
            'location' => Point::class,
        ];
    }
}
