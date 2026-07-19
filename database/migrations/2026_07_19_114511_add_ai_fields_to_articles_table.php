<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('articles', function (Blueprint $table) {

            $table->foreignId('country_id')
                ->nullable()
                ->after('content')
                ->constrained()
                ->nullOnDelete();

            $table->string('source')
                ->nullable()
                ->after('country_id');

            $table->timestamp('published_at')
                ->nullable()
                ->after('source');

            $table->enum('sentiment',[
                'Positive',
                'Neutral',
                'Negative'
            ])
            ->default('Neutral')
            ->after('published_at');

            $table->integer('risk_score')
                ->default(0)
                ->after('sentiment');

        });
    }

    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {

            $table->dropForeign(['country_id']);

            $table->dropColumn([
                'country_id',
                'source',
                'published_at',
                'sentiment',
                'risk_score'
            ]);

        });
    }
};