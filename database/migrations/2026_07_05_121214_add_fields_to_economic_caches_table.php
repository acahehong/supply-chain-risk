<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('economic_caches', function (Blueprint $table) {

            $table->foreignId('country_id')
                  ->nullable()
                  ->constrained()
                  ->nullOnDelete()
                  ->after('id');

            $table->decimal('gdp', 20, 2)->nullable();

            $table->decimal('inflation', 8, 2)->nullable();

            $table->bigInteger('population')->nullable();

            $table->decimal('exports', 20, 2)->nullable();

            $table->decimal('imports', 20, 2)->nullable();

            $table->timestamp('fetched_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('economic_caches', function (Blueprint $table) {

            $table->dropForeign(['country_id']);

            $table->dropColumn([
                'country_id',
                'gdp',
                'inflation',
                'population',
                'exports',
                'imports',
                'fetched_at'
            ]);

        });
    }
};