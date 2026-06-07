<?php

declare(strict_types=1);

namespace App\Http\Controllers\PilotActions;

use App\Http\Controllers\Controller;
use App\Models\Route;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\QueryBuilder\QueryBuilder;

final class FlightController extends Controller
{
    public function list(Request $request): Response
    {
        $currentUserLocation = request()->user()->currentAirport;
        $query = Route::fromUserLocation($currentUserLocation->id);
        $routes = QueryBuilder::for($query)
            ->allowedSorts('flight_time')
            ->paginate($request->integer('perPage', 15));

        return Inertia::render('pilot-actions/book-flight/BookFlight', [
            'routes' => $routes,
        ]);
    }
}
