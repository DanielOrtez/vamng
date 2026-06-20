<?php

declare(strict_types=1);

namespace App\Actions\PilotActions;

use App\Concerns\DataTableQueryRules;
use App\Http\Requests\PilotActions\BookFlightIndexRequest;
use App\Models\Airport;
use App\Models\Route;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

final class ListDepartingRoutes
{
    use DataTableQueryRules;

    /**
     * @return LengthAwarePaginator<int, Route>
     */
    public function __invoke(BookFlightIndexRequest $request, Airport $departureAirport): LengthAwarePaginator
    {
        return QueryBuilder::for(Route::fromLocation($departureAirport->id), $request)
            ->allowedSorts(...$this->allowedSorts())
            ->allowedFilters(AllowedFilter::partial('arrival_airport', 'arrivalAirport.icao'))
            ->paginate($request->integer('perPage', self::PER_PAGE));
    }

    /**
     * @return string[]
     */
    private function allowedSorts(): array
    {
        return ['flight_time', 'departure_time', 'arrival_time', 'distance'];
    }
}
