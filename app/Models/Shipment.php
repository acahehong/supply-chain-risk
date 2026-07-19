<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    protected $fillable = [

        'tracking_code',

        'origin_port_id',

        'destination_port_id',

        'departure_date',

        'eta',

        'progress',

        'delay_days',

        'status',

    ];

    protected $casts = [

        'departure_date' => 'date',

        'eta' => 'date',

    ];

    public function originPort()
    {
        return $this->belongsTo(Port::class, 'origin_port_id');
    }

    public function destinationPort()
    {
        return $this->belongsTo(Port::class, 'destination_port_id');
    }

}