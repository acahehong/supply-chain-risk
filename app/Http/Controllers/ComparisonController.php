<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\EconomicCache;
use App\Models\CurrencyCache;
use App\Models\RiskScore;
use App\Models\WeatherCache;

class ComparisonController extends Controller
{
    public function index()
    {
        $countries = Country::all();

        $country1 = request('country1');
        $country2 = request('country2');

        $data1 = null;
        $data2 = null;

        if ($country1 && $country2) {

           $data1 = Country::with([
                'economicCache',
                'riskScores',
                'ports.weatherCache',
                'currencyCache'
            ])->find($country1);

            $data2 = Country::with([
                'economicCache',
                'riskScores',
                'ports.weatherCache',
                'currencyCache'
            ])->find($country2);
        }

        return view('comparison', compact(
            'countries',
            'data1',
            'data2'
        ));
    }
}