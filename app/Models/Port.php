<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Port extends Model
{
    protected $fillable = [
        'country_id',
        'name',
        'latitude',
        'longitude',
        'type',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function weatherCache()
    {
        return $this->hasOne(WeatherCache::class);
    }

    public function originShipments()
{
    return $this->hasMany(Shipment::class, 'origin_port_id');
}

public function destinationShipments()
{
    return $this->hasMany(Shipment::class, 'destination_port_id');
}
}