<?php

declare(strict_types=1);

namespace App\Http\Controllers\PilotActions;

use App\Http\Controllers\Controller;
use App\Models\Route;
use Inertia\Inertia;
use Inertia\Response;

final class FlightController extends Controller
{
    public function list(): Response
    {
        $currentUserAirport = request()->user()->currentAirport;
        $routesFrom = Route::where('departure_airport_id', $currentUserAirport?->id)->get();

        return Inertia::render('pilot-actions/book-flight/BookFlight', [
            'routes' => $routesFrom,
        ]);
    }
}
