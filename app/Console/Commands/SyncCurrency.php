<?php

namespace App\Console\Commands;

use App\Models\Country;
use App\Models\CurrencyCache;
use App\Services\ExchangeRateService;
use Illuminate\Console\Command;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Attributes\Description;

#[Signature('currency:sync')]
#[Description('Sync exchange rates from Exchange Rate API')]
class SyncCurrency extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $service = new ExchangeRateService();

        $countries = Country::all();

        foreach ($countries as $country) {

            $this->info("Syncing {$country->name}...");

            $rate = $service->getRate($country->currency_code);

            if ($rate === null) {

                $this->warn("Rate {$country->currency_code} tidak ditemukan.");

                continue;
            }

            CurrencyCache::updateOrCreate(

                [
                    'country_id' => $country->id,
                ],

                [
                    'base_currency' => 'USD',
                    'target_currency' => $country->currency_code,
                    'exchange_rate' => $rate,
                    'fetched_at' => now(),
                ]

            );

        }

        $this->info('');
        $this->info('===================================');
        $this->info('Currency synced successfully!');
        $this->info('===================================');

        return Command::SUCCESS;
    }
}