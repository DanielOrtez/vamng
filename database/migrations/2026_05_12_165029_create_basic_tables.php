<?php

declare(strict_types=1);

use App\Enums\AircraftTypeEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('airports', function (Blueprint $table): void {
            $table->id();
            $table->char('icao', 4)->unique();
            $table->char('iata', 3)->nullable();
            $table->string('name');
            $table->char('iso_2_country', 2);
            $table->integer('elevation_ft')->nullable();
            $table->double('latitude');
            $table->double('longitude');
            $table->boolean('is_hub')->default(false);
            $table->timestamps();
        });

        Schema::create('ranks', function (Blueprint $table): void {
            $table->id();
            $table->string('name')->unique();
            $table->unsignedInteger('hours');
            $table->string('image_url')->nullable();
            $table->timestamps();
        });

        Schema::create('aircraft_types', function (Blueprint $table): void {
            $table->id();
            $table->enum('type', AircraftTypeEnum::cases());
            $table->char('icao', 4)->unique();
            $table->unsignedInteger('range_nm')->nullable();
            $table->unsignedInteger('pax_capacity')->nullable();
            $table->unsignedInteger('cargo_capacity')->nullable();
            $table->string('image_url')->nullable();
            $table->timestamps();
        });

        Schema::create('aircrafts', function (Blueprint $table): void {
            $table->id();
            $table->string('registration')->unique();
            $table->string('name')->nullable();
            $table->unsignedInteger('hours_flown')->default(0);
            $table->foreignId('aircraft_type_id')->constrained()->cascadeOnDelete();
            $table->foreignId('hub_id')->nullable()->constrained('airports')->nullOnDelete();
            $table->foreignId('curr_location_id')->nullable()->constrained('airports')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('routes', function (Blueprint $table): void {
            $table->id();
            $table->char('type', 2);
            $table->string('code');
            $table->foreignId('departure_airport_id')->constrained('airports')->cascadeOnDelete();
            $table->foreignId('arrival_airport_id')->constrained('airports')->cascadeOnDelete();
            $table->foreignId('aircraft_type_id')->nullable()->constrained()->nullOnDelete();
            $table->integer('distance')->nullable();
            $table->text('route')->nullable();
            $table->time('departure_time')->nullable();
            $table->time('arrival_time')->nullable();
            $table->time('flight_time')->nullable();
            $table->unsignedInteger('cost_index')->nullable();
            $table->timestamps();

            $table->index('type');
            $table->index('code');
        });

        Schema::create('users', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->foreignId('rank_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('hub_id')->nullable()->constrained('airports')->nullOnDelete();
            $table->foreignId('curr_airport_id')->nullable()->constrained('airports')->nullOnDelete();
            $table->text('two_factor_secret')->nullable();
            $table->text('two_factor_recovery_codes')->nullable();
            $table->timestamp('two_factor_confirmed_at')->nullable();
            $table->rememberToken();
            $table->timestamps();

            $table->index('rank_id');
            $table->index('hub_id');
            $table->index('curr_airport_id');
        });

        Schema::create('password_reset_tokens', function (Blueprint $table): void {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table): void {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');
        Schema::dropIfExists('routes');
        Schema::dropIfExists('aircrafts');
        Schema::dropIfExists('aircraft_types');
        Schema::dropIfExists('ranks');
        Schema::dropIfExists('airports');
    }
};
