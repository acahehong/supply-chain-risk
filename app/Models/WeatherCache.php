<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeatherCache extends Model
{
    protected $fillable = [
        'port_id',
        'temperature',
        'wind_speed',
        'precipitation',
        'weather_code',
        'storm_risk',
        'fetched_at',
    ];

    protected $casts = [
        'fetched_at' => 'datetime',
    ];

    public function port()
    {
        return $this->belongsTo(Port::class);
    }
}