<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

final class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('airports')->insert([
            [
                'icao' => 'LEBL',
                'name' => 'El Prat',
                'iso_2_country' => 'es',
                'latitude' => 41.297100,
                'longitude' => 2.078460,
            ],
        ]);
    }
}
