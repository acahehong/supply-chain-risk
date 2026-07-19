<x-app-layout>

<div class="container-fluid py-4">

    {{-- HEADER --}}
    <div class="card border-0 shadow-lg mb-4"
        style="background:linear-gradient(135deg,#1e3a8a,#2563eb);border-radius:20px;">

        <div class="card-body d-flex justify-content-between align-items-center">

            <div>

                <h2 class="text-white fw-bold mb-1">
                    📦 Shipment Detail
                </h2>

                <p class="text-white-50 mb-0">
                    AI Supply Chain Monitoring & Delay Prediction
                </p>

            </div>

            <a href="{{ route('shipments.index') }}"
               class="btn btn-light rounded-pill px-4 fw-bold">

                ← Back to Shipments

            </a>

        </div>

    </div>

    {{-- ROUTE SUMMARY --}}

    <div class="row g-4 mb-4">

        <div class="col-md-4">

            <div class="card dashboard-card h-100">

                <div class="card-body">

                    <small class="text-secondary">
                        Tracking Number
                    </small>

                    <h3 class="text-info fw-bold mt-2">
                        {{ $shipment->tracking_code }}
                    </h3>

                    <hr class="border-secondary">

                    <p class="mb-2 text-light">

                        <strong>Status :</strong>

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

                    </p>

                    <p class="mb-2 text-light">

                        <strong>ETA :</strong>

                        {{ $shipment->eta->format('d M Y') }}

                    </p>

                    <p class="mb-0 text-light">

                        <strong>Predicted ETA :</strong>

                        {{ $predictedEta->format('d M Y') }}

                    </p>

                </div>

            </div>

        </div>

        <div class="col-md-8">

            <div class="card dashboard-card h-100">

                <div class="card-header">

                    🚢 Shipment Route

                </div>

                <div class="card-body">

                    <div class="row align-items-center">

                        <div class="col-md-5 text-center">

                            <h4 class="text-success fw-bold">

                                {{ $shipment->originPort->country->name }}

                            </h4>

                            <h6 class="text-light">

                                {{ $shipment->originPort->name }}

                            </h6>

                        </div>

                        <div class="col-md-2 text-center">

                            <h1 class="text-info">

                                ➜

                            </h1>

                        </div>

                        <div class="col-md-5 text-center">

                            <h4 class="text-primary fw-bold">

                                {{ $shipment->destinationPort->country->name }}

                            </h4>

                            <h6 class="text-light">

                                {{ $shipment->destinationPort->name }}

                            </h6>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    {{-- ORIGIN & DESTINATION --}}

    <div class="row g-4 mb-4">

        <div class="col-md-6">

            <div class="card dashboard-card h-100">

                <div class="card-header bg-success text-white">

                    🌍 Origin Information

                </div>

                <div class="card-body">

                    <table class="table table-dark table-borderless">

                        <tr>

                            <td>Country</td>

                            <td>{{ $shipment->originPort->country->name }}</td>

                        </tr>

                        <tr>

                            <td>Port</td>

                            <td>{{ $shipment->originPort->name }}</td>

                        </tr>

                        <tr>

                            <td>Temperature</td>

                            <td>{{ optional($shipment->originPort->weatherCache)->temperature }} °C</td>

                        </tr>

                        <tr>

                            <td>Wind Speed</td>

                            <td>{{ optional($shipment->originPort->weatherCache)->wind_speed }} km/h</td>

                        </tr>

                        <tr>

                            <td>Rainfall</td>

                            <td>{{ optional($shipment->originPort->weatherCache)->precipitation }} mm</td>

                        </tr>

                        <tr>

                            <td>Storm Risk</td>

                            <td>

                                @php
                                    $storm = optional($shipment->originPort->weatherCache)->storm_risk;
                                @endphp

                                @if($storm=="High")

                                    <span class="badge bg-danger">HIGH</span>

                                @elseif($storm=="Medium")

                                    <span class="badge bg-warning text-dark">MEDIUM</span>

                                @else

                                    <span class="badge bg-success">LOW</span>

                                @endif

                            </td>

                        </tr>

                    </table>

                </div>

            </div>

        </div>

        <div class="col-md-6">

            <div class="card dashboard-card h-100">

                <div class="card-header bg-primary text-white">

                    🎯 Destination Information

                </div>

                <div class="card-body">

                    <table class="table table-dark table-borderless">

                        <tr>

                            <td>Country</td>

                            <td>{{ $shipment->destinationPort->country->name }}</td>

                        </tr>

                        <tr>

                            <td>Port</td>

                            <td>{{ $shipment->destinationPort->name }}</td>

                        </tr>

                        <tr>

                            <td>Temperature</td>

                            <td>{{ optional($shipment->destinationPort->weatherCache)->temperature }} °C</td>

                        </tr>

                        <tr>

                            <td>Wind Speed</td>

                            <td>{{ optional($shipment->destinationPort->weatherCache)->wind_speed }} km/h</td>

                        </tr>

                        <tr>

                            <td>Rainfall</td>

                            <td>{{ optional($shipment->destinationPort->weatherCache)->precipitation }} mm</td>

                        </tr>

                        <tr>

                            <td>Storm Risk</td>

                            <td>

                                @php
                                    $storm = optional($shipment->destinationPort->weatherCache)->storm_risk;
                                @endphp

                                @if($storm=="High")

                                    <span class="badge bg-danger">HIGH</span>

                                @elseif($storm=="Medium")

                                    <span class="badge bg-warning text-dark">MEDIUM</span>

                                @else

                                    <span class="badge bg-success">LOW</span>

                                @endif

                            </td>

                        </tr>

                    </table>

                </div>

            </div>

        </div>

    </div>

    {{-- SHIPMENT PROGRESS & AI PREDICTION --}}

<div class="row g-4 mb-4">

    {{-- Shipment Progress --}}
    <div class="col-lg-6">

        <div class="card dashboard-card h-100">

            <div class="card-header">

                📊 Shipment Progress

            </div>

            <div class="card-body">

                <h5 class="text-info mb-3">

                    {{ $shipment->progress }}%

                </h5>

                <div class="progress mb-4" style="height:25px;">

                    <div class="progress-bar bg-info progress-bar-striped progress-bar-animated"

                        style="width:{{ $shipment->progress }}%">

                        {{ $shipment->progress }}%

                    </div>

                </div>

                <table class="table table-dark table-borderless">

                    <tr>

                        <td width="45%">Tracking Code</td>

                        <td>{{ $shipment->tracking_code }}</td>

                    </tr>

                    <tr>

                        <td>Current Status</td>

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

                    </tr>

                    <tr>

                        <td>ETA</td>

                        <td>

                            {{ $shipment->eta->format('d M Y') }}

                        </td>

                    </tr>

                    <tr>

                        <td>Predicted ETA</td>

                        <td>

                            {{ $predictedEta->format('d M Y') }}

                        </td>

                    </tr>

                </table>

            </div>

        </div>

    </div>

    {{-- AI Prediction --}}
    <div class="col-lg-6">

        <div class="card dashboard-card h-100">

            <div class="card-header">

                🤖 AI Delay Prediction

            </div>

            <div class="card-body text-center">

                @if($prediction=="High")

                    <span class="badge bg-danger fs-6 px-4 py-2">

                        HIGH RISK

                    </span>

                @elseif($prediction=="Medium")

                    <span class="badge bg-warning text-dark fs-6 px-4 py-2">

                        MEDIUM RISK

                    </span>

                @else

                    <span class="badge bg-success fs-6 px-4 py-2">

                        LOW RISK

                    </span>

                @endif

                <h1 class="display-4 fw-bold text-white mt-3">

                    {{ $predictionScore }}

                    <small class="fs-4">/100</small>

                </h1>

                <div class="progress mt-4 mb-4" style="height:24px;">

                    @if($prediction=="High")

                        <div class="progress-bar bg-danger"

                    @elseif($prediction=="Medium")

                        <div class="progress-bar bg-warning"

                    @else

                        <div class="progress-bar bg-success"

                    @endif

                        style="width:{{ $predictionScore }}%">

                        {{ $predictionScore }}%

                    </div>

                </div>

                <div class="alert alert-info text-start">

                    <strong>💡 AI Recommendation</strong>

                    <hr>

                    {{ $recommendation }}

                </div>

            </div>

        </div>

    </div>

</div>

{{-- AI ANALYSIS --}}

<div class="row g-4 mb-4">

    {{-- Analysis Reasons --}}
    <div class="col-lg-8">

        <div class="card dashboard-card h-100">

            <div class="card-header">

                🧠 AI Analysis Breakdown

            </div>

            <div class="card-body">

                @foreach($reasons as $reason)

                    <div class="d-flex align-items-start mb-3">

                        <div class="me-3">

                            <span class="badge bg-primary rounded-circle p-2">

                                ✓

                            </span>

                        </div>

                        <div>

                            <span class="text-light">

                                {{ $reason }}

                            </span>

                        </div>

                    </div>

                @endforeach

            </div>

        </div>

    </div>

    {{-- Risk Summary --}}
    <div class="col-lg-4">

        <div class="card dashboard-card h-100">

            <div class="card-header">

                ⚠ Risk Summary

            </div>

            <div class="card-body">

                <div class="mb-4">

                    <small class="text-secondary">

                        Prediction Score

                    </small>

                    <h2 class="text-info fw-bold">

                        {{ $predictionScore }}/100

                    </h2>

                </div>

                <div class="mb-4">

                    <small class="text-secondary">

                        AI Status

                    </small>

                    <br>

                    @if($prediction=="High")

                        <span class="badge bg-danger fs-6">

                            HIGH RISK

                        </span>

                    @elseif($prediction=="Medium")

                        <span class="badge bg-warning text-dark fs-6">

                            MEDIUM RISK

                        </span>

                    @else

                        <span class="badge bg-success fs-6">

                            LOW RISK

                        </span>

                    @endif

                </div>

                <div class="mb-4">

                    <small class="text-secondary">

                        Shipment Progress

                    </small>

                    <h4 class="text-white">

                        {{ $shipment->progress }}%

                    </h4>

                </div>

                <div class="mb-4">

                    <small class="text-secondary">

                        Estimated Arrival

                    </small>

                    <h5 class="text-light">

                        {{ $predictedEta->format('d M Y') }}

                    </h5>

                </div>

                <hr class="border-secondary">

                <div class="text-center">

                    @if($prediction=="High")

                        <h5 class="text-danger">

                            🚨 Immediate Attention Required

                        </h5>

                    @elseif($prediction=="Medium")

                        <h5 class="text-warning">

                            ⚠ Continue Monitoring

                        </h5>

                    @else

                        <h5 class="text-success">

                            ✅ Shipment Stable

                        </h5>

                    @endif

                </div>

            </div>

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

const predictionValue = {{ $predictionScore }};

new Chart(document.getElementById('predictionChart'),{

    type:'doughnut',

    data:{

        labels:['Risk','Remaining'],

        datasets:[{

            data:[predictionValue,100-predictionValue],

            backgroundColor:[

                predictionValue>=60 ? '#ef4444' :
                predictionValue>=30 ? '#f59e0b' :
                '#22c55e',

                '#374151'

            ],

            borderWidth:0

        }]

    },

    options:{

        responsive:true,

        cutout:'75%',

        plugins:{

            legend:{

                display:false

            }

        }

    }

});

</script>

<style>

body{

    background:#0f172a;

}

.dashboard-card{

    background:#111827;

    border:none;

    border-radius:18px;

    box-shadow:0 8px 25px rgba(0,0,0,.35);

}

.card-header{

    background:#1e293b;

    color:white;

    font-weight:700;

    border:none;

}

.table{

    margin-bottom:0;

}

.table td{

    color:white;

    border-color:#374151;

}

.progress{

    background:#374151;

    border-radius:20px;

}

.progress-bar{

    border-radius:20px;

}

.alert{

    border:none;

    border-radius:15px;

}

.badge{

    font-size:.85rem;

}

</style>

</x-app-layout>