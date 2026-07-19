<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Country;
use App\Models\CurrencyCache;

class SyncExchange extends Command
{
    protected $signature = 'exchange:sync';

    protected $description = 'Sync exchange rate for all countries';

    public function handle()
    {
        foreach (Country::all() as $country) {

            if (empty($country->currency_code)) {
                $this->warn("Skip {$country->name}");
                continue;
            }

            try {

                $response = Http::get(
                    "https://open.er-api.com/v6/latest/USD"
                );

                if (!$response->successful()) {
                    continue;
                }

                $rates = $response->json('rates');

                if (!isset($rates[$country->currency_code])) {
                    continue;
                }

                CurrencyCache::updateOrCreate(

                    [
                        'country_id' => $country->id,
                    ],

                    [
                        'base_currency' => 'USD',
                        'target_currency' => $country->currency_code,
                        'exchange_rate' => $rates[$country->currency_code],
                        'fetched_at' => now(),
                    ]

                );

                $this->info("✔ {$country->name}");

            } catch (\Exception $e) {

                $this->error($country->name);

            }

        }

        $this->info("Exchange Sync Finished");
    }
}