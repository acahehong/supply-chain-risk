<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // User default
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $this->call([
            CountrySeeder::class,
            PortSeeder::class,
            PositiveWordSeeder::class,
            NegativeWordSeeder::class,
            ShipmentSeeder::class,
        ]);
    }
}