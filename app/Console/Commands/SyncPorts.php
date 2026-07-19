<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Country;
use App\Models\Port;

class SyncPorts extends Command
{
    protected $signature = 'sync:ports';

    protected $description = 'Import World Port Index';

    public function handle()
    {
        $path = storage_path('app/ports/world_ports.csv');

        if (!file_exists($path)) {
            $this->error('world_ports.csv tidak ditemukan!');
            return;
        }

        $file = fopen($path, 'r');

        // Header CSV
        $header = fgetcsv($file);
        $imported = 0;
        $skipped = 0;

        while (($row = fgetcsv($file)) !== false) {

            $data = array_combine($header, $row);


            $country = Country::where('name', trim($data['Country Code']))->first();

            if (!$country) {
                $skipped++;
                continue;
          }
           Port::updateOrCreate(
                [
                    'country_id' => $country->id,
                    'name' => trim($data['Main Port Name']),
                ],
                [
                    'latitude' => $data['Latitude'],
                    'longitude' => $data['Longitude'],
                    'type' => 'Seaport',
                ]
            );

$imported++;
        }

        fclose($file);

        $this->info("==========================");
        $this->info("Imported : ".$imported);
        $this->info("Skipped  : ".$skipped);
        $this->info("Total Ports : ".Port::count());
        $this->info("==========================");
    }
}