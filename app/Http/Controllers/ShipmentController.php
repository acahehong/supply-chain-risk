<?php

namespace App\Http\Controllers;

use App\Models\Shipment;

class ShipmentController extends Controller
{
    public function index()
    {
        $shipments = Shipment::with([
            'originPort.country',
            'destinationPort.country',
            'originPort.weatherCache',
            'destinationPort.weatherCache'
        ])->get();

        return view('shipments.index', compact('shipments'));
    }

    public function show(Shipment $shipment)
{
    $shipment->load([
        'originPort.country.riskScores',
        'destinationPort.country.riskScores',
        'originPort.weatherCache',
        'destinationPort.weatherCache'
    ]);

    

    $originWeather = $shipment->originPort->weatherCache;
    $destinationWeather = $shipment->destinationPort->weatherCache;

    $predictionScore = 0;
    $reasons = [];

    /*
    |--------------------------------------------------------------------------
    | COUNTRY RISK
    |--------------------------------------------------------------------------
    */

    $originRisk = optional(
        $shipment->originPort->country->riskScores->last()
    )->total_score ?? 0;

    $destinationRisk = optional(
        $shipment->destinationPort->country->riskScores->last()
    )->total_score ?? 0;

    $countryRisk = round(($originRisk + $destinationRisk) / 2);

    $predictionScore += $countryRisk;

    $reasons[] = "Origin Country Risk : {$originRisk}";
    $reasons[] = "Destination Country Risk : {$destinationRisk}";
    $reasons[] = "Average Country Risk : {$countryRisk}";

    /*
    |--------------------------------------------------------------------------
    | STORM RISK
    |--------------------------------------------------------------------------
    */

    foreach ([
        'Origin' => $originWeather,
        'Destination' => $destinationWeather
    ] as $location => $weather) {

        $storm = optional($weather)->storm_risk;

        if ($storm == 'High') {

            $predictionScore += 30;
            $reasons[] = "{$location} Storm Risk : High";

        } elseif ($storm == 'Medium') {

            $predictionScore += 15;
            $reasons[] = "{$location} Storm Risk : Medium";

        } else {

            $predictionScore += 5;
            $reasons[] = "{$location} Storm Risk : Low";

        }
    }

    /*
    |--------------------------------------------------------------------------
    | WIND SPEED
    |--------------------------------------------------------------------------
    */

    foreach ([
        'Origin' => $originWeather,
        'Destination' => $destinationWeather
    ] as $location => $weather) {

        $wind = optional($weather)->wind_speed ?? 0;

        if ($wind >= 40) {

            $predictionScore += 30;
            $reasons[] = "{$location} Wind : Very Strong ({$wind} km/h)";

        } elseif ($wind >= 20) {

            $predictionScore += 15;
            $reasons[] = "{$location} Wind : Strong ({$wind} km/h)";

        } elseif ($wind >= 10) {

            $predictionScore += 5;
            $reasons[] = "{$location} Wind : Moderate ({$wind} km/h)";

        }
    }

    /*
    |--------------------------------------------------------------------------
    | RAINFALL
    |--------------------------------------------------------------------------
    */

    foreach ([
        'Origin' => $originWeather,
        'Destination' => $destinationWeather
    ] as $location => $weather) {

        $rain = optional($weather)->precipitation ?? 0;

        if ($rain >= 50) {

            $predictionScore += 30;
            $reasons[] = "{$location} Rainfall : Heavy ({$rain} mm)";

        } elseif ($rain >= 10) {

            $predictionScore += 15;
            $reasons[] = "{$location} Rainfall : Moderate ({$rain} mm)";

        } elseif ($rain > 0) {

            $predictionScore += 5;
            $reasons[] = "{$location} Rainfall : Light ({$rain} mm)";

        }
    }

    /*
    |--------------------------------------------------------------------------
    | SHIPMENT STATUS
    |--------------------------------------------------------------------------
    */

    if ($shipment->status == 'Delayed') {

        $predictionScore += 25;
        $reasons[] = 'Shipment Status : Delayed';

    } elseif ($shipment->status == 'Possible Delay') {

        $predictionScore += 15;
        $reasons[] = 'Shipment Status : Possible Delay';

    } else {

        $reasons[] = 'Shipment Status : On Schedule';
    }

    /*
    |--------------------------------------------------------------------------
    | PROGRESS
    |--------------------------------------------------------------------------
    */

    if ($shipment->progress >= 90) {

        $predictionScore -= 10;
        $reasons[] = 'Shipment almost arrived';

    } elseif ($shipment->progress >= 70) {

        $predictionScore -= 5;
        $reasons[] = 'Shipment near destination';
    }

    // Batasi skor

    $predictionScore = max(0, min(100, $predictionScore));

    /*
    |--------------------------------------------------------------------------
    | AI Prediction
    |--------------------------------------------------------------------------
    */

    if ($predictionScore >= 60) {

        $prediction = 'High';

        $recommendation = 'High probability of delay. Consider changing shipping schedule or route.';

    } elseif ($predictionScore >= 30) {

        $prediction = 'Medium';

        $recommendation = 'Shipment may experience delays. Continue monitoring weather and logistics conditions.';

    } else {

        $prediction = 'Low';

        $recommendation = 'Shipment is expected to arrive on schedule.';
    }

    /*
|--------------------------------------------------------------------------
| PREDICTED ETA
|--------------------------------------------------------------------------
*/

$predictedEta = \Carbon\Carbon::parse($shipment->eta);

if($prediction == 'Medium'){

    $predictedEta->addDay();

}elseif($prediction == 'High'){

    $predictedEta->addDays(3);

}

    return view(
        'shipments.show',
       compact(
        'shipment',
        'prediction',
        'predictionScore',
        'recommendation',
        'reasons',
        'predictedEta'

        )
    );
}
}