<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PositiveWord;

class PositiveWordSeeder extends Seeder
{
    public function run(): void
    {
        $words = [
            'stable',
            'growth',
            'improved',
            'improvement',
            'recover',
            'recovery',
            'resumed',
            'resume',
            'efficient',
            'increase',
            'expanded',
            'expansion',
            'success',
            'successful',
            'safe',
            'secured',
            'normal',
            'boost',
            'strong',
            'available',
            'delivered',
            'export',
            'import',
            'innovation',
            'opportunity',
        ];

        foreach ($words as $word) {
            PositiveWord::firstOrCreate([
                'word' => $word,
            ]);
        }
    }
}