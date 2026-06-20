<?php

declare(strict_types=1);

namespace App\Actions\PilotActions;

use App\Concerns\DataTableQueryRules;
use App\Http\Requests\PilotActions\SelectAircraftRequest;
use App\Models\Aircraft;
use App\Models\Route;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

final class ListAvailableAircrafts
{
    use DataTableQueryRules;

    /**
     * @return LengthAwarePaginator<int, Aircraft>
     */
    public function __invoke(SelectAircraftRequest $request, Route $route): LengthAwarePaginator
    {
        return QueryBuilder::for($this->availableAircraftsQuery($route), $request)
            ->allowedSorts(...$this->allowedSorts())
            ->allowedFilters(AllowedFilter::exact('aircraft_type', 'aircraft_type_id'))
            ->paginate($request->integer('perPage', self::PER_PAGE));
    }

    /**
     * @return string[]
     */
    private function allowedSorts(): array
    {
        return ['hours_flown'];
    }

    /**
     * @return Builder<Aircraft>
     */
    private function availableAircraftsQuery(Route $route): Builder
    {
        return Aircraft::notBooked()
            ->where('curr_location_id', $route->departure_airport_id)
            ->whereIn('aircraft_type_id', $route->aircraftTypes->pluck('id'))
            ->with('aircraftType:id,icao');
    }
}
