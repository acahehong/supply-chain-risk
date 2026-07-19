<x-app-layout>

<div class="container py-4">

<div class="card border-0 shadow-lg mb-4"
style="background:linear-gradient(135deg,#0f172a,#2563eb);border-radius:20px;">

    <div class="card-body d-flex justify-content-between align-items-center">

        <div>

            <h2 class="text-white fw-bold mb-1">
                📦 Shipment Monitoring Dashboard
            </h2>

            <p class="text-white-50 mb-0">
                AI-based Global Shipment Tracking & Logistics Monitoring
            </p>

        </div>

        <a href="{{ route('dashboard') }}"
        class="btn btn-light rounded-pill px-4 fw-bold">

            ← Dashboard

        </a>

    </div>

</div>

<div class="row g-4 mb-4">

    <div class="col-lg-3">

        <div class="card dashboard-card text-center">

            <div class="card-body">

                <h6 class="text-secondary">
                    Total Shipment
                </h6>

                <h1 class="text-info fw-bold">
                    {{ $total }}
                </h1>

            </div>

        </div>

    </div>

    <div class="col-lg-3">

        <div class="card dashboard-card text-center">

            <div class="card-body">

                <h6 class="text-secondary">
                    On Schedule
                </h6>

                <h1 class="text-success fw-bold">
                    {{ $schedule }}
                </h1>

            </div>

        </div>

    </div>

    <div class="col-lg-3">

        <div class="card dashboard-card text-center">

            <div class="card-body">

                <h6 class="text-secondary">
                    Possible Delay
                </h6>

                <h1 class="text-warning fw-bold">
                    {{ $possible }}
                </h1>

            </div>

        </div>

    </div>

    <div class="col-lg-3">

        <div class="card dashboard-card text-center">

            <div class="card-body">

                <h6 class="text-secondary">
                    Delayed
                </h6>

                <h1 class="text-danger fw-bold">
                    {{ $delayed }}
                </h1>

            </div>

        </div>

    </div>

</div>

<div class="row g-4 mb-4">

    <div class="col-lg-4">

        <div class="card dashboard-card text-center">

            <div class="card-body">

                <h6 class="text-secondary">
                    Delivered
                </h6>

                <h2 class="text-primary fw-bold">
                    {{ $delivered }}
                </h2>

            </div>

        </div>

    </div>

    <div class="col-lg-4">

        <div class="card dashboard-card text-center">

            <div class="card-body">

                <h6 class="text-secondary">
                    Average Progress
                </h6>

                <h2 class="text-info fw-bold">
                    {{ $averageProgress }}%
                </h2>

            </div>

        </div>

    </div>

    <div class="col-lg-4">

        <div class="card dashboard-card text-center">

            <div class="card-body">

                <h6 class="text-secondary">
                    On Time Rate
                </h6>

                <h2 class="text-success fw-bold">
                    {{ $onTimeRate }}%
                </h2>

            </div>

        </div>

    </div>

</div>

<div class="row g-4 mb-4">

    <div class="col-lg-6">

        <div class="card dashboard-card h-100">

            <div class="card-header">

                📊 Shipment Status Distribution

            </div>

            <div class="card-body">

                <canvas id="statusChart"></canvas>

            </div>

        </div>

    </div>

    <div class="col-lg-6">

        <div class="card dashboard-card h-100">

            <div class="card-header">

                📈 Shipment Progress

            </div>

            <div class="card-body">

                <canvas id="progressChart"></canvas>

            </div>

        </div>

    </div>

</div>

{{-- Table --}}

<div class="card dashboard-card">

<div class="card-header">

📦 Latest Shipment List

</div>

<div class="card-body p-0">

<table class="table table-dark table-hover align-middle mb-0">

<thead class="table-header-pink">

<tr>

<th>Tracking</th>

<th>Origin</th>

<th>Destination</th>

<th>Progress</th>

<th>Status</th>

<th>Action</th>

</tr>

</thead>

<tbody>

@foreach($shipments as $shipment)

<tr>

<td>

{{ $shipment->tracking_code }}

</td>

<td>

{{ $shipment->originPort->country->name }}

</td>

<td>

{{ $shipment->destinationPort->country->name }}

</td>

<td width="220">

<div class="progress" style="height:20px;">

<div
class="progress-bar bg-info progress-bar-striped progress-bar-animated"
style="width:{{ $shipment->progress }}%">

{{ $shipment->progress }}%

</div>

</div>
</td>

<td>

@if($shipment->status=='Delayed')

<span class="badge bg-danger">

Delayed

</span>

@elseif($shipment->status=='Possible Delay')

<span class="badge bg-warning text-dark">

Possible Delay

</span>

@elseif($shipment->status=='Delivered')

<span class="badge bg-info">

Delivered

</span>

@else

<span class="badge bg-info">

On Schedule

</span>

@endif

</td>

<td>

<a
href="{{ route('shipments.show',$shipment) }}"
class="btn btn-info btn-sm rounded-pill">

View

</a>

</td>

</tr>

@endforeach

</tbody>

</table>

</div>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

new Chart(document.getElementById('statusChart'),{

    type:'doughnut',

    data:{

        labels:[
            'On Schedule',
            'Possible Delay',
            'Delayed',
            'Delivered'
        ],

        datasets:[{

            data:[
                {{ $schedule }},
                {{ $possible }},
                {{ $delayed }},
                {{ $delivered }}
            ],

            backgroundColor:[
                '#22c55e',
                '#f59e0b',
                '#ef4444',
                '#38bdf8'
            ],

            borderWidth:0

        }]

    },

    options:{

        responsive:true,

        plugins:{

            legend:{

                labels:{

                    color:'white'

                }

            }

        }

    }

});

new Chart(document.getElementById('progressChart'),{

    type:'bar',

    data:{

        labels:[

            @foreach($shipments->take(10) as $shipment)

                '{{ $shipment->tracking_code }}',

            @endforeach

        ],

        datasets:[{

            label:'Progress (%)',

            data:[

                @foreach($shipments->take(10) as $shipment)

                    {{ $shipment->progress }},

                @endforeach

            ],

            backgroundColor:'#38bdf8',

            borderRadius:8

        }]

    },

    options:{

        responsive:true,

        plugins:{

            legend:{

                labels:{

                    color:'white'

                }

            }

        },

        scales:{

            x:{

                ticks:{

                    color:'white'

                },

                grid:{

                    color:'#334155'

                }

            },

            y:{

                beginAtZero:true,

                max:100,

                ticks:{

                    color:'white'

                },

                grid:{

                    color:'#334155'

                }

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

.table thead{

    background:#1e293b;

}

.table th{

    color:#38bdf8;

    border-color:#374151;

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

.badge{

    font-size:.82rem;

    padding:.55rem .9rem;

}

.btn-info{

    color:white;

}

</style>

</x-app-layout>