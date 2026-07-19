<?php

namespace App\Http\Controllers;

use App\Models\Shipment;

class ShipmentMonitoringController extends Controller
{
   public function index()
{
    $shipments = Shipment::with([
        'originPort.country',
        'destinationPort.country'
    ])->latest()->get();

    $total = $shipments->count();

    $delayed = Shipment::where('status','Delayed')->count();

    $possible = Shipment::where('status','Possible Delay')->count();

    $schedule = Shipment::where('status','On Schedule')->count();

    $delivered = Shipment::where('status','Delivered')->count();

    $averageProgress = round($shipments->avg('progress') ?? 0);

    $delayRate = $total
        ? round(($delayed/$total)*100)
        : 0;

    $onTimeRate = $total
        ? round(($schedule/$total)*100)
        : 0;

    return view('shipments.monitoring',compact(

        'shipments',

        'total',

        'delayed',

        'possible',

        'schedule',

        'delivered',

        'averageProgress',

        'delayRate',

        'onTimeRate'

    ));
}
}