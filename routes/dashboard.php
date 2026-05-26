<?php

declare(strict_types=1);

use App\Http\Controllers\PilotActions\FlightController;

Route::middleware(['auth', 'verified'])->group(function (): void {
    Route::get('book_flight', [FlightController::class, 'list'])->name('flight.list');
});
