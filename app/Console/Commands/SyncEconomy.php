<?php

namespace App\Console\Commands;

use App\Models\Country;
use App\Models\EconomicCache;
use App\Services\WorldBankService;
use Illuminate\Console\Command;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Attributes\Description;

#[Signature('economy:sync')]
#[Description('Sync economy data from World Bank API')]
class SyncEconomy extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $service = new WorldBankService();

        $countries = Country::all();

        foreach ($countries as $country) {

            $this->info("Syncing {$country->name}...");

            // Gunakan kode ISO3 langsung (IDN, CHN, USA, dll)
          $data = $service->getCountryData($country->code);

               if (
    is_null($data['gdp']) &&
    is_null($data['inflation']) &&
    is_null($data['population']) &&
    is_null($data['exports']) &&
    is_null($data['imports'])
) {
    $this->warn("SKIPPED : {$country->name}");
    continue;
}

if (
    is_null($data['gdp']) &&
    is_null($data['inflation']) &&
    is_null($data['population'])
) {
    $this->error("FAILED : {$country->name} ({$country->code})");
    continue;
}

$this->info("GDP : ".$data['gdp']);

EconomicCache::updateOrCreate(

                [
                    'country_id' => $country->id,
                ],

                [
                    'gdp' => $data['gdp'],
                    'inflation' => $data['inflation'],
                    'population' => $data['population'],
                    'exports' => $data['exports'],
                    'imports' => $data['imports'],
                    'fetched_at' => now(),
                ]

            );

            $this->line("✔ {$country->name} selesai");
            usleep(200000); // 0.2 detik
        }

        $this->info('');
        $this->info('===================================');
        $this->info('Economy synced successfully!');
        $this->info('===================================');

        return Command::SUCCESS;
    }
}