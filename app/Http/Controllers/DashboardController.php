<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Port;
use App\Models\RiskScore;
use App\Models\EconomicCache;
use App\Models\CurrencyCache;
use App\Models\NewsCache;

class DashboardController extends Controller
{
    public function index()
    {
        $countries = Country::with('riskScores')->get();

        $ports = Port::with([
            'country.riskScores',
            'weatherCache'
        ])->get();

        foreach ($ports as $port) {

            $risk = $port->country
                ->riskScores()
                ->latest()
                ->first();

            if ($risk) {

                $port->risk = [

                    'score' => $risk->total_score,

                    'level' => strtoupper($risk->risk_level),

                    'color' => match ($risk->risk_level) {

                        'High' => 'red',

                        'Medium' => 'orange',

                        'Low' => 'green',

                        default => 'gray'

                    }

                ];

            } else {

                $port->risk = [

                    'score' => 0,

                    'level' => 'UNKNOWN',

                    'color' => 'gray'

                ];

            }

        }

        $riskChart = RiskScore::with('country')
    ->orderByDesc('total_score')
    ->get();

$chartLabels = [];
$chartValues = [];

foreach ($riskChart as $risk) {

    $chartLabels[] = $risk->country->name;

    $chartValues[] = $risk->total_score;

}
// ========================
// GDP Chart
// ========================

$economies = EconomicCache::with('country')->get();

$gdpLabels = [];
$gdpValues = [];

foreach ($economies as $eco) {

    $gdpLabels[] = $eco->country->name;

    // dibagi 1 triliun supaya grafik tidak terlalu besar
    $gdpValues[] = round($eco->gdp / 1000000000000, 2);

}

// ========================
// Inflation Chart
// ========================

$inflationLabels = [];
$inflationValues = [];

foreach ($economies as $eco) {

    $inflationLabels[] = $eco->country->name;

    $inflationValues[] = $eco->inflation;

}

// ========================
// Export Chart
// ========================

$exportLabels = [];
$exportValues = [];

foreach ($economies as $eco) {

    $exportLabels[] = $eco->country->name;

    // dibagi 1 triliun
    $exportValues[] = round($eco->exports / 1000000000000, 2);

}

// ========================
// Import Chart
// ========================

$importLabels = [];
$importValues = [];

foreach ($economies as $eco) {

    $importLabels[] = $eco->country->name;

    $importValues[] = round($eco->imports / 1000000000000, 2);

}

// ========================
// Currency Chart
// ========================

$currencies = CurrencyCache::with('country')->get();

$currencyLabels = [];
$currencyValues = [];

foreach ($currencies as $currency) {

    $currencyLabels[] = $currency->country->name;

    $currencyValues[] = $currency->exchange_rate;

}

// ========================
// Latest News
// ========================

$latestNews = NewsCache::with('country')
    ->latest()
    ->get();


        return view('dashboard', [

    // Data utama
    'countries' => $countries,
    'ports' => $ports,

    // Statistik
    'totalCountries' => Country::count(),
    'totalPorts' => Port::count(),
    'totalWeather' => \App\Models\WeatherCache::count(),
    'totalEconomy' => \App\Models\EconomicCache::count(),
    'totalCurrency' => \App\Models\CurrencyCache::count(),
    'totalNews' => \App\Models\NewsCache::count(),
    'totalRisk' => \App\Models\RiskScore::count(),

    // Risk Chart
    'chartLabels' => $chartLabels,
    'chartValues' => $chartValues,

    // GDP Chart
    'gdpLabels' => $gdpLabels,
    'gdpValues' => $gdpValues,

    // Inflation Chart
    'inflationLabels' => $inflationLabels,
    'inflationValues' => $inflationValues,

    // Currency Chart
    'currencyLabels' => $currencyLabels,
    'currencyValues' => $currencyValues,

    // Export Chart
    'exportLabels' => $exportLabels,
    'exportValues' => $exportValues,

    // Import Chart
    'importLabels' => $importLabels,
    'importValues' => $importValues,

    // News
    'latestNews' => $latestNews,

]);

    }
    }