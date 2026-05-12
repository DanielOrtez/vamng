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
    }
}
