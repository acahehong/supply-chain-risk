<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\WeatherCache;

class UpdateWeatherExtras extends Command
{
    protected $signature = 'weather:update-extras';

    protected $description = 'Update precipitation and storm risk';

    public function handle()
    {
        $rows = WeatherCache::with('port')->get();

        $success = 0;
        $failed = 0;

        foreach ($rows as $weather) {

            if (!$weather->port) {
                continue;
            }

            try {

                $response = Http::timeout(20)->get(
                    'https://api.open-meteo.com/v1/forecast',
                    [
                        'latitude' => $weather->port->latitude,
                        'longitude' => $weather->port->longitude,

                        'daily' => 'precipitation_sum',

                        'forecast_days' => 1,

                        'timezone' => 'auto'
                    ]
                );

                if (!$response->successful()) {
                    $failed++;
                    continue;
                }

                $json = $response->json();

                $precipitation =
                    $json['daily']['precipitation_sum'][0] ?? 0;

                $wind = $weather->wind_speed;

                if ($wind >= 60 || $precipitation >= 50) {

                    $storm = 'High';

                } elseif ($wind >= 30 || $precipitation >= 20) {

                    $storm = 'Medium';

                } else {

                    $storm = 'Low';

                }

                $weather->update([

                    'precipitation' => $precipitation,

                    'storm_risk' => $storm,

                ]);

                $success++;

                $this->line("[$success] ".$weather->port->name);

                usleep(100000);

            } catch (\Exception $e) {

                $failed++;

            }

        }

        $this->info("======================");
        $this->info("SUCCESS : ".$success);
        $this->info("FAILED  : ".$failed);
        $this->info("======================");
    }
}