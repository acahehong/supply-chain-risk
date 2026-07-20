<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

/*
|--------------------------------------------------------------------------
| Scheduler
|--------------------------------------------------------------------------
*/

Schedule::command('currency:sync')->everyTenMinutes();

// Jika ada scheduler lain bisa ditambahkan
// Schedule::command('weather:sync')->hourly();
// Schedule::command('news:sync')->everyThirtyMinutes();