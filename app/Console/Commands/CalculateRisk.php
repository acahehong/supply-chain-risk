<?php

namespace App\Console\Commands;

use App\Models\Country;
use App\Services\FinalRiskService;
use Illuminate\Console\Command;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Attributes\Description;

#[Signature('risk:calculate')]
#[Description('Calculate final supply chain risk score')]
class CalculateRisk extends Command
{
    public function handle()
    {
        $service = new FinalRiskService();

        foreach (Country::all() as $country) {

            $this->info("Calculating {$country->name}...");

            $service->calculate($country);

        }

        $this->info('Risk calculation completed!');
    }
}