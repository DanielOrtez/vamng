<?php

declare(strict_types=1);

namespace Database\Seeders;

use Clickbar\Magellan\Data\Geometries\Point;
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
            ['id' => 1, 'name' => 'New Pilot', 'hours' => 0, 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('airports')->insert(
            [
                'icao' => 'LEBL',
                'name' => 'Josep Tarradellas Barcelona-El Prat Airport',
                'elevation_ft' => 4,
                'iso_2_country' => 'es',
                'location' => Point::makeGeodetic(41.297100, 2.078460),
                'is_hub' => true,
                'created_at' => now(),
                'updated_at' => now()]
        );
    }
}
