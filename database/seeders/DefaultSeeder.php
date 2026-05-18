<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

final class DefaultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('ranks')->insert([
            ['name' => 'New Pilot', 'hours' => 0, 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('airports')->insert(
            [
                'icao' => 'LEBL',
                'name' => 'Josep Tarradellas Barcelona-El Prat Airport',
                'iso_2_country' => 'ES',
                'latitude' => 41.297100,
                'longitude' => 2.078460,
                'is_hub' => true,
                'created_at' => now(),
                'updated_at' => now()]
        );
    }
}
