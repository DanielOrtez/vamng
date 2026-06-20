<?php

declare(strict_types=1);

namespace App\Http\Requests\PilotActions;

use App\Models\Route;
use Illuminate\Foundation\Http\FormRequest;

final class SelectAircraftRequest extends FormRequest
{
    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [];
    }

    public function authorize(): bool
    {
        $route = $this->route('route');

        return $route instanceof Route
            && $this->user()->currentAirport !== null
            && $route->departure_airport_id === $this->user()->currentAirport->id;
    }
}
