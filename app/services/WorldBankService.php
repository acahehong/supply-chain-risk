<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WorldBankService
{
    /**
     * Mengambil indikator terbaru dari World Bank
     */
    public function getIndicator(string $countryCode, string $indicator)
    {
        $countryCode = strtoupper($countryCode);

        $url = "https://api.worldbank.org/v2/country/{$countryCode}/indicator/{$indicator}?format=json&per_page=100";

        try {

           $response = Http::timeout(10)
                ->retry(1, 500)
                ->acceptJson()
                ->get($url);

        } catch (\Exception $e) {

            return null;

        }

        if (!$response->successful()) {
            return null;
        }

        $json = $response->json();

        if (!isset($json[1]) || !is_array($json[1])) {
            return null;
        }

        // Ambil data terbaru yang memiliki value
        foreach ($json[1] as $row) {

            if (
                isset($row['value']) &&
                $row['value'] !== null
            ) {

                return $row['value'];

            }

        }

        return null;
    }

    /**
     * Mengambil seluruh data ekonomi negara
     */
    public function getCountryData(string $countryCode): array
    {
        $countryCode = strtoupper($countryCode);

        return [

            /*
            |--------------------------------------------------------------------------
            | GDP
            |--------------------------------------------------------------------------
            | NY.GDP.MKTP.CD
            */
            'gdp' => $this->getIndicator(
                $countryCode,
                'NY.GDP.MKTP.CD'
            ),

            /*
            |--------------------------------------------------------------------------
            | Inflation
            |--------------------------------------------------------------------------
            | FP.CPI.TOTL.ZG
            */
            'inflation' => $this->getIndicator(
                $countryCode,
                'FP.CPI.TOTL.ZG'
            ),

            /*
            |--------------------------------------------------------------------------
            | Population
            |--------------------------------------------------------------------------
            | SP.POP.TOTL
            */
            'population' => $this->getIndicator(
                $countryCode,
                'SP.POP.TOTL'
            ),

            /*
            |--------------------------------------------------------------------------
            | Exports of Goods and Services
            |--------------------------------------------------------------------------
            | NE.EXP.GNFS.CD
            */
            'exports' => $this->getIndicator(
                $countryCode,
                'NE.EXP.GNFS.CD'
            ),

            /*
            |--------------------------------------------------------------------------
            | Imports of Goods and Services
            |--------------------------------------------------------------------------
            | NE.IMP.GNFS.CD
            */
            'imports' => $this->getIndicator(
                $countryCode,
                'NE.IMP.GNFS.CD'
            ),

        ];
    }
}