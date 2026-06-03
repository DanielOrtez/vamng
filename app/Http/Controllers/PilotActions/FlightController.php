<?php

declare(strict_types=1);

namespace App\Http\Controllers\PilotActions;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

final class FlightController extends Controller
{
    public function list(): Response
    {
        $currentUserAirport = request()->user()->currentAirport;

        return Inertia::render('pilot-actions/book-flight/BookFlight', [
            'routes' => $currentUserAirport->departureRoutes,
        ]);
    }
}
