<?php

namespace App\Services;

use App\Models\PositiveWord;
use App\Models\NegativeWord;

class SentimentService
{
    public function analyze(string $text): int
    {
        $text = strtolower($text);

        // Hilangkan tanda baca
        $text = preg_replace('/[^a-z0-9\s]/', ' ', $text);

        // Pecah menjadi kata
        $words = preg_split('/\s+/', $text);

        $score = 0;

        $positiveWords = PositiveWord::pluck('word')->toArray();
        $negativeWords = NegativeWord::pluck('word')->toArray();

        foreach ($words as $word) {

            if (in_array($word, $positiveWords)) {
                $score++;
            }

            if (in_array($word, $negativeWords)) {
                $score--;
            }

        }

        return $score;
    }
}