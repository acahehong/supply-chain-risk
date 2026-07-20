<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ExchangeRateService
{
    /**
     * Mengambil seluruh nilai tukar terhadap USD
     */
    public function getLatestRates()
    {
        $url = "https://open.er-api.com/v6/latest/USD";

        $response = Http::timeout(30)->get($url);

        if (!$response->successful()) {
            return null;
        }

        $json = $response->json();

        if (!isset($json['rates'])) {
            return null;
        }

        return $json['rates'];
    }

    /**
     * Mengambil kurs berdasarkan kode mata uang
     */
    public function getRate(string $currencyCode)
    {
        $rates = $this->getLatestRates();

        if (!$rates) {
            return null;
        }

        return $rates[$currencyCode] ?? null;
    }
}