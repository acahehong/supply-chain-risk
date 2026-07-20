<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Port;
use App\Models\WeatherCache;

class SyncWeather extends Command
{
    protected $signature = 'weather:sync';

    protected $description = 'Sync weather for all ports';

    public function handle()
    {
      $ports = Port::whereNotIn('id', function ($query) {
    $query->select('port_id')
          ->from('weather_caches');
})->get();

$this->info("Remaining ports : ".$ports->count());

$success = 0;
$failed = 0;

        foreach ($ports as $port) {

            try {

                $response = Http::timeout(20)->get(
                    'https://api.open-meteo.com/v1/forecast',
                    [
                        'latitude' => $port->latitude,
                        'longitude' => $port->longitude,

                        // Current Weather
                        'current' => 'temperature_2m,wind_speed_10m,weather_code',

                        // Daily Rainfall
                        'daily' => 'precipitation_sum',

                        'timezone' => 'auto'
                    ]
                );

                if (!$response->successful()) {
                    $failed++;
                    continue;
                }

                $json = $response->json();

                $current = $json['current'] ?? null;
                $daily = $json['daily'] ?? null;

                if (!$current || !$daily) {
                    $failed++;
                    continue;
                }

                $temperature = $current['temperature_2m'];
                $windSpeed = $current['wind_speed_10m'];
                $weatherCode = $current['weather_code'];

                $precipitation = $daily['precipitation_sum'][0] ?? 0;

                /*
                |--------------------------------------------------------------------------
                | Storm Risk
                |--------------------------------------------------------------------------
                */

                if ($windSpeed >= 60 || $precipitation >= 50) {

                    $stormRisk = 'High';

                } elseif ($windSpeed >= 30 || $precipitation >= 20) {

                    $stormRisk = 'Medium';

                } else {

                    $stormRisk = 'Low';

                }

                WeatherCache::updateOrCreate(

                    [
                        'port_id' => $port->id
                    ],

                    [
                        'temperature' => $temperature,

                        'wind_speed' => $windSpeed,

                        'precipitation' => $precipitation,

                        'weather_code' => $weatherCode,

                        'storm_risk' => $stormRisk,

                        'fetched_at' => now(),
                    ]

                );

              $success++;

$this->line("[$success/".$ports->count()."] ".$port->name);

                usleep(50000);

            } catch (\Exception $e) {

                $failed++;

                $this->error($port->name.' : '.$e->getMessage());

            }

        }

        $this->info("============================");
        $this->info("SUCCESS : ".$success);
        $this->info("FAILED  : ".$failed);
        $this->info("TOTAL   : ".$ports->count());
        $this->info("============================");
    }
}