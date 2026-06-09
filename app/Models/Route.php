<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\RouteTypeEnum;
use App\Settings\GeneralSettings;
use Carbon\CarbonInterval;
use Illuminate\Database\Eloquent\Attributes\Appends;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Override;

#[Fillable([
    'type',
    'code',
    'departure_airport_id',
    'arrival_airport_id',
    'distance',
    'route',
    'departure_time',
    'arrival_time',
    'flight_time',
    'cost_index',
])]
#[Appends(['route_code'])]
final class Route extends Model
{
    protected $with = ['arrivalAirport:id,icao,name', 'aircraftTypes:id,icao'];

    /**
     * @return BelongsTo<Airport, $this>
     */
    public function departureAirport(): BelongsTo
    {
        return $this->belongsTo(Airport::class, 'departure_airport_id');
    }

    /**
     * @return BelongsTo<Airport, $this>
     */
    public function arrivalAirport(): BelongsTo
    {
        return $this->belongsTo(Airport::class, 'arrival_airport_id');
    }

    /**
     * @return BelongsToMany<AircraftType, $this>
     */
    public function aircraftTypes(): BelongsToMany
    {
        return $this->belongsToMany(AircraftType::class);
    }

    /**
     * @return Attribute<Route, string>
     */
    protected function routeCode(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes): string => sprintf('%s%s', app(GeneralSettings::class)->va_icao, $attributes['code']),
        );
    }

    /**
     * @return Attribute<Route, CarbonInterval>
     */
    protected function flightTimeFormatted(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes): CarbonInterval => CarbonInterval::minutes($attributes['flight_time'])->cascade(),
        );
    }

    /**
     * @param  Builder<self>  $query
     */
    #[Scope]
    protected function fromUserLocation(Builder $query, int|string $location): void
    {
        $query->where('departure_airport_id', $location);
    }

    #[Override]
    protected function casts(): array
    {
        return [
            'type' => RouteTypeEnum::class,
        ];
    }
}
