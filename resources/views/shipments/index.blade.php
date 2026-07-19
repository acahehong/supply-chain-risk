<x-app-layout>

<div class="container-fluid">

<div class="mb-4">

    <h2 class="text-white fw-bold">
        📦 Shipment Intelligence
    </h2>

    <p class="text-secondary">
        Monitor global shipments and logistics performance.
    </p>

</div>

@php

$total = $shipments->count();

$delayed = $shipments->where('status','Delayed')->count();

$possible = $shipments->where('status','Possible Delay')->count();

$onschedule = $shipments->where('status','On Schedule')->count();

@endphp

<div class="row g-4 mb-4">

<div class="col-md-3">

<div class="card bg-primary border-0 shadow">

<div class="card-body text-center">

<h6 class="text-white">
TOTAL SHIPMENTS
</h6>

<h2 class="text-white fw-bold">
{{ $total }}
</h2>

</div>

</div>

</div>

<div class="col-md-3">

<div class="card bg-danger border-0 shadow">

<div class="card-body text-center">

<h6 class="text-white">
DELAYED
</h6>

<h2 class="text-white fw-bold">
{{ $delayed }}
</h2>

</div>

</div>

</div>

<div class="col-md-3">

<div class="card bg-warning border-0 shadow">

<div class="card-body text-center">

<h6>
POSSIBLE
</h6>

<h2 class="fw-bold">
{{ $possible }}
</h2>

</div>

</div>

</div>

<div class="col-md-3">

<div class="card bg-success border-0 shadow">

<div class="card-body text-center">

<h6 class="text-white">
ON SCHEDULE
</h6>

<h2 class="text-white fw-bold">
{{ $onschedule }}
</h2>

</div>

</div>

</div>

</div>

    <div class="card dashboard-card border-0 shadow">

        <div class="card-body">

            <table class="table table-dark table-hover align-middle mb-0">

<thead>

<tr>

<th>Tracking</th>

<th>Origin</th>

<th>Destination</th>

<th>ETA</th>

<th width="220">Progress</th>

<th>Status</th>

<th width="120">Action</th>

</tr>

</thead>

<tbody>

@foreach($shipments as $shipment)

<tr>

<td>

<strong>{{ $shipment->tracking_code }}</strong>

</td>

<td>

🌍 {{ $shipment->originPort->country->name }}

<br>

<small class="text-secondary">

{{ $shipment->originPort->name }}

</small>

</td>

<td>

🌍 {{ $shipment->destinationPort->country->name }}

<br>

<small class="text-secondary">

{{ $shipment->destinationPort->name }}

</small>

</td>

<td>

{{ $shipment->eta->format('d M Y') }}

</td>

<td>

<div class="progress" style="height:12px">

<div
class="progress-bar bg-info"

style="width:{{ $shipment->progress }}%">

</div>

</div>

<div class="small text-end mt-1">

{{ $shipment->progress }}%

</div>

</td>

<td>

@if($shipment->status=="Delayed")

<span class="badge bg-danger">

Delayed

</span>

@elseif($shipment->status=="Possible Delay")

<span class="badge bg-warning text-dark">

Possible Delay

</span>

@else

<span class="badge bg-success">

On Schedule

</span>

@endif

</td>

<td>

<a
href="{{ route('shipments.show',$shipment) }}"
class="btn btn-outline-primary btn-sm">

View

</a>

</td>

</tr>

@endforeach

</tbody>

</table>

</div>

</div>

@if($shipments->count())

<div class="row mt-4 g-4">

    <div class="col-md-4">

        <div class="card dashboard-card shadow border-0">

            <div class="card-body text-center">

                <h6 class="text-secondary">
                    Total Shipments
                </h6>

                <h2 class="text-info fw-bold">
                    {{ $shipments->count() }}
                </h2>

            </div>

        </div>

    </div>

    <div class="col-md-4">

        <div class="card dashboard-card shadow border-0">

            <div class="card-body text-center">

                <h6 class="text-secondary">
                    On Schedule
                </h6>

                <h2 class="text-success fw-bold">
                    {{ $shipments->where('status','On Schedule')->count() }}
                </h2>

            </div>

        </div>

    </div>

    <div class="col-md-4">

        <div class="card dashboard-card shadow border-0">

            <div class="card-body text-center">

                <h6 class="text-secondary">
                    Delayed
                </h6>

                <h2 class="text-danger fw-bold">
                    {{ $shipments->where('status','Delayed')->count() }}
                </h2>

            </div>

        </div>

    </div>

</div>

@endif

</div>

<style>

body{

background:#0f172a;

}

.dashboard-card{

background:#111827;

border-radius:18px;

}

.table{

margin-bottom:0;

color:white;

}

.table thead{

background:#1e293b;

}

.table th{

color:#38bdf8;

border-color:#334155;

}

.table td{

color:white;

border-color:#334155;

vertical-align:middle;

}

.card{

background:#111827;

border:none;

border-radius:18px;

}

.progress{

background:#374151;

height:12px;

border-radius:30px;

}

.progress-bar{

border-radius:30px;

font-size:11px;

font-weight:bold;

}

.btn-primary{

border-radius:10px;

}

.badge{

font-size:13px;

padding:8px 12px;

}

</style>

</x-app-layout>

