<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

final class OptimizeCountriesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('countries', function (Blueprint $table): void {
            // Add indexes for common lookup fields
            $table->index(['region'], 'countries_region_index');
            $table->index(['currency_code'], 'countries_currency_code_index');
            $table->index(['calling_code'], 'countries_calling_code_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('countries', function (Blueprint $table): void {
            $table->dropIndex('countries_region_index');
            $table->dropIndex('countries_currency_code_index');
            $table->dropIndex('countries_calling_code_index');
        });
    }
}
