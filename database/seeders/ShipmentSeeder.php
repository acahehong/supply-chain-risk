<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Shipment;
use App\Models\Port;

class ShipmentSeeder extends Seeder
{
    public function run(): void
    {
        Shipment::truncate();

        $ports = Port::take(10)->get();

        if ($ports->count() < 2) {
            return;
        }

        for ($i = 0; $i < 10; $i++) {

            Shipment::create([
                'tracking_code' => 'SHP'.str_pad($i + 1, 4, '0', STR_PAD_LEFT),

                'origin_port_id' => $ports[$i % $ports->count()]->id,

                'destination_port_id' => $ports[($i + 1) % $ports->count()]->id,

                'departure_date' => now()->subDays(rand(1,5)),

                'eta' => now()->addDays(rand(2,7)),

                'progress' => rand(10,95),

                'delay_days' => rand(0,2),

                'status' => collect([
                    'On Schedule',
                    'Possible Delay',
                    'Delayed'
                ])->random(),
            ]);
        }
    }
}