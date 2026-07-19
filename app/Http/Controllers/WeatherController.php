<?php

namespace App\Http\Controllers;

use App\Models\Port;
use App\Models\WeatherCache;
use Illuminate\Support\Facades\Http;

class WeatherController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Weather Dashboard
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $ports = Port::with('country', 'weatherCache')->get();

        $totalPorts = $ports->count();

        $avgTemp = round(
            $ports->avg(fn($port) => optional($port->weatherCache)->temperature ?? 0),
            1
        );

        $avgWind = round(
            $ports->avg(fn($port) => optional($port->weatherCache)->wind_speed ?? 0),
            1
        );

        $highStorm = $ports->filter(function ($port) {
            return optional($port->weatherCache)->storm_risk === 'High';
        })->count();

        return view('weather.index', compact(
            'ports',
            'totalPorts',
            'avgTemp',
            'avgWind',
            'highStorm'
        ));
    }

    

    /*
    |--------------------------------------------------------------------------
    | Sync Weather API
    |--------------------------------------------------------------------------
    */

    public function sync()
    {
        $ports = Port::all();

        foreach ($ports as $port) {

            if (!$port->latitude || !$port->longitude) {
                continue;
            }

            $response = Http::get('https://api.open-meteo.com/v1/forecast', [
                'latitude' => $port->latitude,
                'longitude' => $port->longitude,
                'current' => 'temperature_2m,wind_speed_10m,weather_code',
            ]);

            if (!$response->successful()) {
                continue;
            }

            $current = $response->json()['current'];

            WeatherCache::updateOrCreate(
                [
                    'port_id' => $port->id,
                ],
                [
                    'temperature' => $current['temperature_2m'],
                    'wind_speed' => $current['wind_speed_10m'],
                    'weather_code' => $current['weather_code'],
                    'fetched_at' => now(),
                ]
            );
        }

        return back()->with('success', 'Weather data synchronized successfully!');
    }
}