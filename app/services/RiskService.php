<?php

namespace App\Services;

class RiskService
{
    /**
     * Menghitung Weather Risk
     */
    public static function calculate($windSpeed, $weatherCode)
    {
        $score = 0;

        /*
        |--------------------------------------------------------------------------
        | WIND SPEED
        |--------------------------------------------------------------------------
        */

        if ($windSpeed >= 35) {

            $score += 50;

        } elseif ($windSpeed >= 25) {

            $score += 40;

        } elseif ($windSpeed >= 15) {

            $score += 30;

        } elseif ($windSpeed >= 10) {

            $score += 20;

        } elseif ($windSpeed >= 5) {

            $score += 10;

        }

        /*
        |--------------------------------------------------------------------------
        | WEATHER CONDITION
        |--------------------------------------------------------------------------
        */

        $moderateWeather = [
            51,53,55,
            61,63,65,
            71,73,75
        ];

        $heavyWeather = [
            66,67,
            80,81,82,
            95,96,99
        ];

        if (in_array($weatherCode, $heavyWeather)) {

            $score += 50;

        } elseif (in_array($weatherCode, $moderateWeather)) {

            $score += 25;

        }

        return self::formatResult(min($score, 100));
    }

    /**
     * Weather + News Sentiment
     */
    public static function calculateFinal(
        $windSpeed,
        $weatherCode,
        $sentimentScore
    )
    {
        $weather = self::calculate(
            $windSpeed,
            $weatherCode
        );

        $newsRisk = max(0, (-1 * $sentimentScore) * 5);

        $score = $weather['score'] + $newsRisk;

        $score = min(100, $score);

        return self::formatResult($score);
    }

    /**
     * Format Risk Result
     */
    private static function formatResult($score)
    {
        if ($score >= 70) {

            return [
                'score' => $score,
                'level' => 'HIGH',
                'color' => 'red',
            ];

        }

        if ($score >= 30) {

            return [
                'score' => $score,
                'level' => 'MEDIUM',
                'color' => 'orange',
            ];

        }

        return [
            'score' => $score,
            'level' => 'LOW',
            'color' => 'green',
        ];
    }
}