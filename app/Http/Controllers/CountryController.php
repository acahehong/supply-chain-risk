<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Support\Facades\Http;

class CountryController extends Controller
{
    /**
     * Menampilkan daftar negara
     */
    public function index()
    {
        $countries = Country::orderBy('name')->get();

        return view('countries.index', compact('countries'));
    }

    /**
     * Sync data dari REST Countries API
     */
    public function sync()
    {
        $response = Http::timeout(60)
            ->acceptJson()
            ->get('https://restcountries.com/v3.1/all');

        if (!$response->successful()) {
            return "Gagal mengambil data REST Countries API.";
        }

        $countries = $response->json();

        foreach ($countries as $item) {

            $capital = isset($item['capital'])
                ? implode(', ', $item['capital'])
                : null;

            $currencyCode = null;
            $currencyName = null;

            if (isset($item['currencies'])) {

                $currencyCode = array_key_first($item['currencies']);

                $currencyName = $item['currencies'][$currencyCode]['name'] ?? null;
            }

            // Languages
            $languages = null;

            if (isset($item['languages'])) {
                $languages = implode(', ', array_values($item['languages']));
            }

            $flag = $item['flags']['png'] ?? null;

            $latitude = $item['latlng'][0] ?? null;
            $longitude = $item['latlng'][1] ?? null;

            Country::updateOrCreate(

                [
                    'code' => $item['cca3'],
                ],

                [
                    'name' => $item['name']['common'] ?? null,
                    'capital' => $capital,
                    'region' => $item['region'] ?? null,
                    'languages' => $languages,
                    'currency_code' => $currencyCode,
                    'currency_name' => $currencyName,
                    'flag' => $flag,
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                ]

            );
        }

        return "Sync Countries Successfully!";
    }
}