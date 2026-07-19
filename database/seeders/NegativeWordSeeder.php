<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\NegativeWord;

class NegativeWordSeeder extends Seeder
{
    public function run(): void
    {
        $words = [

            'delay',
            'delayed',
            'disruption',
            'disrupted',
            'storm',
            'typhoon',
            'hurricane',
            'flood',
            'earthquake',
            'strike',
            'closure',
            'closed',
            'war',
            'conflict',
            'attack',
            'accident',
            'fire',
            'explosion',
            'shortage',
            'congestion',
            'blocked',
            'cancelled',
            'risk',
            'crisis',
            'damage',
            'destroyed',
            'failure',
            'collapse',
            'shutdown',
            'sanction',

        ];

        foreach ($words as $word) {
            NegativeWord::firstOrCreate([
                'word' => $word
            ]);
        }
    }
}