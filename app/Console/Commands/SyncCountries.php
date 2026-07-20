<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Country;
use Illuminate\Support\Facades\File;

class SyncCountries extends Command
{
    protected $signature = 'sync:countries';

    protected $description = 'Import countries from countries.json';

    public function handle()
    {
        $path = database_path('data/countries.json');

        if (!File::exists($path)) {
            $this->error('countries.json tidak ditemukan.');
            return;
        }

        $countries = json_decode(File::get($path), true);

        foreach ($countries as $item) {

            /*
            |--------------------------------------------------------------------------
            | Currency
            |--------------------------------------------------------------------------
            */

            $currencyCode = null;
            $currencyName = null;

            if (
                !empty($item['currencies']) &&
                is_array($item['currencies'])
            ) {

                $currencyCode = array_key_first($item['currencies']);

                if (
                    isset($item['currencies'][$currencyCode]['name'])
                ) {

                    $currencyName = $item['currencies'][$currencyCode]['name'];

                }

            }

            /*
            |--------------------------------------------------------------------------
            | Languages
            |--------------------------------------------------------------------------
            */

            $languages = null;

            if (
                !empty($item['languages']) &&
                is_array($item['languages'])
            ) {

                $languages = implode(
                    ', ',
                    array_values($item['languages'])
                );

            }

            /*
            |--------------------------------------------------------------------------
            | Save Country
            |--------------------------------------------------------------------------
            */

            Country::updateOrCreate(

                [
                    'code' => $item['cca3']
                ],

                [

                    'name' => $item['name']['common'] ?? null,

                    'iso2' => $item['cca2'] ?? null,

                    'capital' => $item['capital'][0] ?? null,

                    'region' => $item['region'] ?? null,

                    'languages' => $languages,

                    'currency_code' => $currencyCode,

                    'currency_name' => $currencyName,

                    'flag' => $item['flags']['png'] ?? null,

                    'latitude' => $item['latlng'][0] ?? null,

                    'longitude' => $item['latlng'][1] ?? null,

                ]

            );

        }

        $this->info('');
        $this->info('===================================');
        $this->info('Countries synced successfully!');
        $this->info('Total Country : ' . Country::count());
        $this->info('===================================');

        return Command::SUCCESS;
    }
}