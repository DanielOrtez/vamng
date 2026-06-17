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

    public function select_aircraft(Request $request, int $routeID)
    {
        $route = Route::with(['aircraftTypes:id', 'departureAirport:id,icao,name'])->find($routeID);
        $query = Aircraft::query()
            ->where('curr_location_id', $route->departure_airport_id)
            ->whereIn('aircraft_type_id', $route->aircraftTypes->pluck('id'))
            ->with('aircraftType')
            ->paginate($request->integer('perPage', 15));

        return Inertia::render('pilot-actions/book-flight/SelectAircraft', [
            'route' => $route,
            'aircrafts' => $query
        ]);
    }
}
