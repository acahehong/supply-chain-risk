<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Port;
use App\Models\Country;

class PortSeeder extends Seeder
{
    public function run(): void
    {
        $ports = [

            [
                'country' => 'IDN',
                'name' => 'Port of Tanjung Priok',
                'latitude' => -6.104900,
                'longitude' => 106.886500,
                'type' => 'Seaport',
            ],

            [
                'country' => 'CHN',
                'name' => 'Port of Shanghai',
                'latitude' => 31.230400,
                'longitude' => 121.473700,
                'type' => 'Seaport',
            ],

            [
                'country' => 'JPN',
                'name' => 'Port of Yokohama',
                'latitude' => 35.443700,
                'longitude' => 139.638000,
                'type' => 'Seaport',
            ],

            [
                'country' => 'SGP',
                'name' => 'Port of Singapore',
                'latitude' => 1.264400,
                'longitude' => 103.840500,
                'type' => 'Seaport',
            ],

            [
                'country' => 'DEU',
                'name' => 'Port of Hamburg',
                'latitude' => 53.546100,
                'longitude' => 9.966100,
                'type' => 'Seaport',
            ],

            [
                'country' => 'AUS',
                'name' => 'Port of Sydney',
                'latitude' => -33.868800,
                'longitude' => 151.209300,
                'type' => 'Seaport',
            ],

            [
                'country' => 'USA',
                'name' => 'Port of Los Angeles',
                'latitude' => 33.736100,
                'longitude' => -118.292300,
                'type' => 'Seaport',
            ],

            [
                'country' => 'KOR',
                'name' => 'Port of Busan',
                'latitude' => 35.102800,
                'longitude' => 129.040300,
                'type' => 'Seaport',
            ],

            [
                'country' => 'IND',
                'name' => 'Port of Mumbai',
                'latitude' => 18.949700,
                'longitude' => 72.840600,
                'type' => 'Seaport',
            ],

            [
                'country' => 'NLD',
                'name' => 'Port of Rotterdam',
                'latitude' => 51.924400,
                'longitude' => 4.477700,
                'type' => 'Seaport',
            ],

        ];

        foreach ($ports as $port) {

            $country = Country::where('code', $port['country'])->first();

            if (!$country) {
                continue;
            }

            Port::updateOrCreate(
                [
                    'country_id' => $country->id,
                    'name' => $port['name'],
                ],
                [
                    'latitude' => $port['latitude'],
                    'longitude' => $port['longitude'],
                    'type' => $port['type'],
                ]
            );
        }
    }
}