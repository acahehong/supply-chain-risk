<?php

namespace App\Services;

use App\Models\Country;
use App\Models\CurrencyCache;
use App\Models\EconomicCache;
use App\Models\NewsCache;
use App\Models\Port;
use App\Models\RiskScore;

class FinalRiskService
{
    public function calculate(Country $country)
    {
        /*
        |--------------------------------------------------------------------------
        | WEATHER (MAX 30)
        |--------------------------------------------------------------------------
        */

        $weather = 0;

        $ports = Port::with('weatherCache')
            ->where('country_id', $country->id)
            ->get();

        foreach ($ports as $port) {

            if (!$port->weatherCache) {
                continue;
            }

            $risk = RiskService::calculate(
                $port->weatherCache->wind_speed,
                $port->weatherCache->weather_code
            );

            if ($risk['score'] >= 80) {

    $weather += 30;

}
elseif ($risk['score'] >= 60) {

    $weather += 25;

}
elseif ($risk['score'] >= 40) {

    $weather += 20;

}
elseif ($risk['score'] >= 20) {

    $weather += 10;

}

        }

        if ($ports->count() > 0) {

            $weather = round($weather / $ports->count());

        }

        /*
        |--------------------------------------------------------------------------
        | INFLATION (MAX 20)
        |--------------------------------------------------------------------------
        */

        $inflation = 0;

        $eco = EconomicCache::where(
            'country_id',
            $country->id
        )->first();

        if ($eco) {

            if ($eco->inflation >= 10) {

                $inflation = 20;

            } elseif ($eco->inflation >= 5) {

                $inflation = 15;

            } elseif ($eco->inflation >= 3) {

                $inflation = 10;

            } elseif ($eco->inflation >= 2) {

                $inflation = 5;

            }

        }

        /*
        |--------------------------------------------------------------------------
        | CURRENCY (MAX 10)
        |--------------------------------------------------------------------------
        */

        $currency = 0;

        $rate = CurrencyCache::where(
            'country_id',
            $country->id
        )->first();

        if ($rate) {

            /*
             Karena kita hanya punya snapshot kurs,
             semua negara diberi skor kecil.
             Nanti bisa dikembangkan menjadi
             perubahan kurs harian.
            */

            if ($rate) {

    if ($rate->exchange_rate < 0.5) {

        $currency = 20;

    } elseif ($rate->exchange_rate < 1) {

        $currency = 15;

    } elseif ($rate->exchange_rate < 2) {

        $currency = 10;

    } else {

        $currency = 5;

    }

}

        }

        /*
        |--------------------------------------------------------------------------
        | NEWS (MAX 40)
        |--------------------------------------------------------------------------
        */

        /*
|--------------------------------------------------------------------------
| NEWS (MAX 40)
|--------------------------------------------------------------------------
*/

$news = 0;

$negativeNews = NewsCache::where(
    'country_id',
    $country->id
)
->where('sentiment_score', '<', 0)
->count();

if ($negativeNews >= 5) {

    $news = 40;

} elseif ($negativeNews >= 3) {

    $news = 30;

} elseif ($negativeNews >= 2) {

    $news = 20;

} elseif ($negativeNews >= 1) {

    $news = 15;

}
  /*
|--------------------------------------------------------------------------
| TOTAL
|--------------------------------------------------------------------------
*/

$total =
    $weather +
    $inflation +
    $currency +
    $news;

if ($total >= 50) {

    $level = "High";

} elseif ($total >= 30) {

    $level = "Medium";

} else {

    $level = "Low";

}

        RiskScore::updateOrCreate(

            [
                'country_id' => $country->id
            ],

            [
                'weather_score' => $weather,
                'inflation_score' => $inflation,
                'currency_score' => $currency,
                'news_score' => $news,
                'total_score' => $total,
                'risk_level' => $level,
            ]

        );
    }
}