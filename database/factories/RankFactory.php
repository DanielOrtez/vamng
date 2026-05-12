<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Rank;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Rank>
 */
final class RankFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => 'New Pilot',
            'hours' => 0,
            'image_url' => null,
        ];
    }
}
