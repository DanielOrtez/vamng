<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

final class SetupCountriesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Creates the countries table
        Schema::create('countries', function (Blueprint $table): void {
            $table->string('iso_3166_2', 2)->primary();
            $table->string('name', 255);
            $table->string('capital', 255)->nullable();
            $table->string('iso_3166_3', 3);
            $table->string('currency_code', 3)->nullable();
            $table->string('currency_name', 255)->nullable();
            $table->string('currency_symbol', 10)->nullable();
            $table->string('calling_code', 30)->nullable();
            $table->string('region', 50)->nullable();
            $table->json('languages')->nullable();
            $table->string('flag', 10)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('countries');
    }
}
