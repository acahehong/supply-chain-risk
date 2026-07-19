<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('weather_caches', function (Blueprint $table) {

            $table->decimal('precipitation', 8, 2)
                  ->nullable()
                  ->after('wind_speed');

            $table->string('storm_risk')
                  ->nullable()
                  ->after('weather_code');

        });
    }

    public function down(): void
    {
        Schema::table('weather_caches', function (Blueprint $table) {

            $table->dropColumn([
                'precipitation',
                'storm_risk'
            ]);

        });
    }
};