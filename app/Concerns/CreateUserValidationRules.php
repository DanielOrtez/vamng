<?php

declare(strict_types=1);

namespace App\Concerns;

use Illuminate\Contracts\Validation\ValidationRule;

trait CreateUserValidationRules
{
    /**
     * @return array<string, array<int, ValidationRule|array<mixed>|string>>
     */
    protected function extraCreateUserRules(): array
    {
        return [
            'country' => ['required', 'string', 'max:2'],
            'hub' => ['required', 'integer', 'exists:App\Models\Airport,id'],
        ];
    }
}
