<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\RouteTypeEnum;
use App\Settings\GeneralSettings;
use Carbon\CarbonInterval;
use Clickbar\Magellan\Database\PostgisFunctions\ST;
use Illuminate\Database\Eloquent\Attributes\Appends;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;
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

    private static float $M_PER_NM = 1852;

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

    #[Override]
    protected static function booted(): void
    {
        self::saving(function (self $route): void {
            if ($route->isDirty('departure_airport_id') || $route->isDirty('arrival_airport_id')) {
                $departure = Airport::findOrFail($route->departure_airport_id);
                $arrival = Airport::findOrFail($route->arrival_airport_id);

                $distanceM = DB::query()
                    ->select([ST::distanceSphere($departure->location, $arrival->location)->as('distance')])
                    ->value('distance');

                $route->distance = (int) round($distanceM / self::$M_PER_NM);
            }
        });
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
