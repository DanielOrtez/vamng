<?php

declare(strict_types=1);

namespace App\Http\Controllers\PilotActions;

use App\Actions\PilotActions\ListAvailableAircrafts;
use App\Actions\PilotActions\ListDepartingRoutes;
use App\Http\Controllers\Controller;
use App\Http\Requests\PilotActions\BookFlightIndexRequest;
use App\Http\Requests\PilotActions\SelectAircraftRequest;
use App\Models\Route;
use Inertia\Inertia;
use Inertia\Response;

final class BookFlightController extends Controller
{
    public function __construct(
        private readonly ListDepartingRoutes $listDepartingRoutes,
        private readonly ListAvailableAircrafts $listAvailableAircrafts
    ) {}

    public function list(BookFlightIndexRequest $request): Response
    {
        return Inertia::render('pilot-actions/book-flight/BookFlight', [
            'routes' => ($this->listDepartingRoutes)($request, $request->user()->currentAirport),
        ]);
    }

    public function selectAircraft(SelectAircraftRequest $request, Route $route): Response
    {
        return Inertia::render('pilot-actions/book-flight/SelectAircraft', [
            'route' => $route->load('departureAirport:id,icao,name'),
            'aircrafts' => ($this->listAvailableAircrafts)($request, $route),
            'aircraftTypes' => $route->aircraftTypes,
        ]);
    }
}
