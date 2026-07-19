<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\CurrencyCache;
use Illuminate\Support\Facades\Http;

class CurrencyController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Currency Dashboard
    |--------------------------------------------------------------------------
    */

     public function index()
    {
        // Ambil data kurs terbaru langsung dari API
        $response = Http::get('https://open.er-api.com/v6/latest/USD');

        if (!$response->successful()) {
            return back()->with('error', 'Gagal mengambil data kurs real-time.');
        }

        $rates = $response->json()['rates'];

        // Gabungkan dengan data negara
        $currencies = Country::all()->map(function ($country) use ($rates) {

            return (object) [
                'country' => $country,
                'base_currency' => 'USD',
                'target_currency' => $country->currency_code,
                'exchange_rate' => $rates[$country->currency_code] ?? null,
                'fetched_at' => now(),
            ];
        });

        return view('currency.index', compact('currencies'));
    }


    /*
    |--------------------------------------------------------------------------
    | Sync Currency API
    |--------------------------------------------------------------------------
    */

    public function sync()
    {
        $response = Http::get('https://open.er-api.com/v6/latest/USD');

        if (!$response->successful()) {
            return back()->with('error', 'Gagal mengambil data kurs.');
        }

        $rates = $response->json()['rates'];

        foreach (Country::all() as $country) {

            if (isset($rates[$country->currency_code])) {

                CurrencyCache::updateOrCreate(
                    [
                        'country_id' => $country->id,
                    ],
                    [
                        'base_currency'   => 'USD',
                        'target_currency' => $country->currency_code,
                        'exchange_rate'   => $rates[$country->currency_code],
                        'fetched_at'      => now(),
                    ]
                );
            }
        }

        return back()->with('success', 'Currency berhasil diupdate.');
    }
}