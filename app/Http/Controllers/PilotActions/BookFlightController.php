<?php

declare(strict_types=1);

namespace App\Http\Controllers\PilotActions;

use App\Http\Controllers\Controller;
use App\Models\Aircraft;
use App\Models\Route;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

final class BookFlightController extends Controller
{
    public function list(Request $request): Response
    {
        $query = Route::fromLocation($request->user()->currentAirport->id);
        $routes = QueryBuilder::for($query)
            ->allowedSorts('flight_time', 'departure_time', 'arrival_time', 'distance')
            ->allowedFilters(AllowedFilter::partial('arrival_airport', 'arrivalAirport.icao'))
            ->paginate($request->integer('perPage', 15));

        return Inertia::render('pilot-actions/book-flight/BookFlight', [
            'routes' => $routes,
        ]);
    }

    public function selectAircraft(Request $request, int $routeID)
    {
        $route = Route::with(['aircraftTypes:id,icao', 'departureAirport:id,icao,name'])->find($routeID);
        $aircraftTypes = $route->aircraftTypes;

        $query = Aircraft::notBooked()
            ->where('curr_location_id', $route->departure_airport_id)
            ->whereIn('aircraft_type_id', $aircraftTypes->pluck('id'))
            ->with('aircraftType');

        $aircrafts = QueryBuilder::for($query)
            ->allowedSorts('hours_flown')
            ->allowedFilters(AllowedFilter::exact('aircraft_type', 'aircraft_type_id'))
            ->paginate($request->integer('perPage', 15));

        return Inertia::render('pilot-actions/book-flight/SelectAircraft', [
            'route' => $route,
            'aircrafts' => $aircrafts,
            'aircraftTypes' => $aircraftTypes
        ]);
    }
}
