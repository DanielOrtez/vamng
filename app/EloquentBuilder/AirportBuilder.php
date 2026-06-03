<?php

declare(strict_types=1);

namespace App\EloquentBuilder;

use App\Models\Airport;
use Illuminate\Database\Eloquent\Builder;

/**
 * @extends Builder<Airport>
 */
final class AirportBuilder extends Builder
{
    public function hubs(): self
    {
        return $this->where('is_hub', true);
    }
}
