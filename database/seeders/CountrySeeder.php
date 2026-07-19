<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;

class CountrySeeder extends Seeder
{
    public function run(): void
    {
        $countries = [

            [
                'name' => 'Indonesia',
                'code' => 'IDN',
                'capital' => 'Jakarta',
                'region' => 'Asia',
                'latitude' => -2.548926,
                'longitude' => 118.014863,
                'flag' => 'https://flagcdn.com/w320/id.png',
            ],

            [
                'name' => 'China',
                'code' => 'CHN',
                'capital' => 'Beijing',
                'region' => 'Asia',
                'latitude' => 35.861660,
                'longitude' => 104.195397,
                'flag' => 'https://flagcdn.com/w320/cn.png',
            ],

            [
                'name' => 'Japan',
                'code' => 'JPN',
                'capital' => 'Tokyo',
                'region' => 'Asia',
                'latitude' => 36.204824,
                'longitude' => 138.252924,
                'flag' => 'https://flagcdn.com/w320/jp.png',
            ],

            [
                'name' => 'Singapore',
                'code' => 'SGP',
                'capital' => 'Singapore',
                'region' => 'Asia',
                'latitude' => 1.352083,
                'longitude' => 103.819836,
                'flag' => 'https://flagcdn.com/w320/sg.png',
            ],

            [
                'name' => 'Germany',
                'code' => 'DEU',
                'capital' => 'Berlin',
                'region' => 'Europe',
                'latitude' => 51.165691,
                'longitude' => 10.451526,
                'flag' => 'https://flagcdn.com/w320/de.png',
            ],

            [
                'name' => 'Australia',
                'code' => 'AUS',
                'capital' => 'Canberra',
                'region' => 'Oceania',
                'latitude' => -25.274398,
                'longitude' => 133.775136,
                'flag' => 'https://flagcdn.com/w320/au.png',
            ],

            [
                'name' => 'United States',
                'code' => 'USA',
                'capital' => 'Washington D.C.',
                'region' => 'North America',
                'latitude' => 37.090240,
                'longitude' => -95.712891,
                'flag' => 'https://flagcdn.com/w320/us.png',
            ],

            [
                'name' => 'South Korea',
                'code' => 'KOR',
                'capital' => 'Seoul',
                'region' => 'Asia',
                'latitude' => 35.907757,
                'longitude' => 127.766922,
                'flag' => 'https://flagcdn.com/w320/kr.png',
            ],

            [
                'name' => 'India',
                'code' => 'IND',
                'capital' => 'New Delhi',
                'region' => 'Asia',
                'latitude' => 20.593684,
                'longitude' => 78.962880,
                'flag' => 'https://flagcdn.com/w320/in.png',
            ],

            [
                'name' => 'Netherlands',
                'code' => 'NLD',
                'capital' => 'Amsterdam',
                'region' => 'Europe',
                'latitude' => 52.132633,
                'longitude' => 5.291266,
                'flag' => 'https://flagcdn.com/w320/nl.png',
            ],

        ];

        foreach ($countries as $country) {
            Country::updateOrCreate(
                ['code' => $country['code']],
                $country
            );
        }
    }
}