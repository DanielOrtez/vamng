<?php

declare(strict_types=1);

namespace App\Http\Requests\PilotActions;

use Illuminate\Foundation\Http\FormRequest;

final class BookFlightIndexRequest extends FormRequest
{
    public function rules(): array
    {
        return [];
    }

    public function authorize(): bool
    {
        return $this->user()->currentAirport !== null;
    }
}
