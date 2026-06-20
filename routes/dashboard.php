<?php

declare(strict_types=1);

use App\Http\Controllers\PilotActions\BookFlightController;

Route::middleware(['auth', 'verified'])->group(function (): void {
    Route::prefix('flights')->group(function () {
        Route::prefix('book')->group(function () {
            Route::get('/', [BookFlightController::class, 'list'])->name('flights.book.list');
            Route::get('/{routeID}/select-aircraft', [BookFlightController::class, 'selectAircraft'])->name('flights.book.selectAircraft');
        });
    });
});
