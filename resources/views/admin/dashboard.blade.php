<x-app-layout>

<div class="container-fluid py-4">

<div class="card border-0 shadow-lg mb-4"
style="background:linear-gradient(135deg,#1e3a8a,#2563eb);border-radius:20px;">

<div class="card-body d-flex justify-content-between align-items-center">

<div>

<h2 class="text-white fw-bold mb-1">

🛡 Admin Dashboard

</h2>

<p class="text-white-50 mb-0">

Supply Chain Risk Monitor Management System

</p>

</div>

<a href="{{ route('dashboard') }}"
class="btn btn-light rounded-pill px-4 fw-bold">

⬅ Dashboard

</a>

</div>

</div>

<div class="row g-4 mb-4">

<div class="col-lg-3">

<div class="card dashboard-card text-center">

<div class="card-body">

<div style="font-size:45px">🌍</div>

<h2 class="text-info fw-bold">

{{ $totalCountries }}

</h2>

<p class="text-secondary mb-0">

Countries

</p>

</div>

</div>

</div>

<div class="col-lg-3">

<div class="card dashboard-card text-center">

<div class="card-body">

<div style="font-size:45px">⚓</div>

<h2 class="text-primary fw-bold">

{{ $totalPorts }}

</h2>

<p class="text-secondary mb-0">

Ports

</p>

</div>

</div>

</div>

<div class="col-lg-3">

<div class="card dashboard-card text-center">

<div class="card-body">

<div style="font-size:45px">📦</div>

<h2 class="text-warning fw-bold">

{{ $totalShipments }}

</h2>

<p class="text-secondary mb-0">

Shipments

</p>

</div>

</div>

</div>

<div class="col-lg-3">

<div class="card dashboard-card text-center">

<div class="card-body">

<div style="font-size:45px">👤</div>

<h2 class="text-success fw-bold">

{{ $totalUsers }}

</h2>

<p class="text-secondary mb-0">

Users

</p>

</div>

</div>

</div>

</div>

<div class="row g-4 mb-4">

<div class="col-lg-6">

<div class="card dashboard-card h-100">

<div class="card-header">

📊 Shipment Status

</div>

<div class="card-body">

<canvas id="shipmentChart" height="220"></canvas>

</div>

</div>

</div>

<div class="col-lg-6">

<div class="card dashboard-card h-100">

<div class="card-header">

📈 Shipment Progress

</div>

<div class="card-body text-center">

<h1 class="display-3 text-info fw-bold">

{{ $avgProgress }}%

</h1>

<div class="progress mt-4" style="height:25px;">

<div class="progress-bar bg-info progress-bar-striped progress-bar-animated"

style="width:{{ $avgProgress }}%">

{{ $avgProgress }}%

</div>

</div>

<div class="row text-center mt-4">

<div class="col-4">

<h4 class="text-success">

{{ $onSchedule }}

</h4>

<small class="text-secondary">

On Schedule

</small>

</div>

<div class="col-4">

<h4 class="text-warning">

{{ $possibleDelay }}

</h4>

<small class="text-secondary">

Possible Delay

</small>

</div>

<div class="col-4">

<h4 class="text-danger">

{{ $delayedShipments }}

</h4>

<small class="text-secondary">

Delayed

</small>

</div>

</div>

</div>

</div>

</div>

</div>

<div class="row g-4 mb-4">

<div class="col-lg-4">

<div class="card dashboard-card text-center">

<div class="card-body">

<div style="font-size:45px">

📰

</div>

<h2 class="text-success fw-bold">

{{ $totalNews }}

</h2>

<p class="text-secondary mb-0">

News Articles

</p>

</div>

</div>

</div>

<div class="col-lg-4">

<div class="card dashboard-card text-center">

<div class="card-body">

<div style="font-size:45px">

🚚

</div>

<h2 class="text-primary fw-bold">

{{ $delivered }}

</h2>

<p class="text-secondary mb-0">

Delivered Shipment

</p>

</div>

</div>

</div>

<div class="col-lg-4">

<div class="card dashboard-card text-center">

<div class="card-body">

<div style="font-size:45px">

⚡

</div>

<h2 class="text-warning fw-bold">

{{ $possibleDelay + $delayedShipments }}

</h2>

<p class="text-secondary mb-0">

Need Attention

</p>

</div>

</div>

</div>

</div>

<div class="card dashboard-card mb-4">

<div class="card-header">

⚙ Quick Actions

</div>

<div class="card-body">

<div class="row g-3">

<div class="col-md-3">

<a href="{{ route('admin.users') }}"
class="btn btn-primary w-100 py-3">

👤<br>

Manage Users

</a>

</div>

<div class="col-md-3">

<a href="{{ route('admin.ports') }}"
class="btn btn-info w-100 py-3 text-white">

⚓<br>

Manage Ports

</a>

</div>

<div class="col-md-3">

<a href="{{ route('news.index') }}"
class="btn btn-success w-100 py-3">

📰<br>

Latest News

</a>

</div>

<div class="col-md-3">

<a href="{{ route('shipment.monitoring') }}"
class="btn btn-warning w-100 py-3">

📦<br>

Shipment Monitor

</a>

</div>

<div class="col-md-3">

    <a href="{{ route('admin.articles') }}"
   class="btn btn-dark w-100 py-3">

        📰<br>

        Analysis Articles

    </a>

</div>

</div>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

new Chart(document.getElementById('shipmentChart'),{

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

{{ $onSchedule }},

{{ $possibleDelay }},

{{ $delayedShipments }},

{{ $delivered }}

],

backgroundColor:[

'#22c55e',

'#f59e0b',

'#ef4444',

'#3b82f6'

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

.card-body{
    color:white;
}

.text-secondary{
    color:#cbd5e1 !important;
}

.progress{
    background:#374151;
    border-radius:20px;
}

.progress-bar{
    border-radius:20px;
}

.btn{
    border-radius:12px;
    font-weight:600;
    transition:.3s;
}

.btn:hover{
    transform:translateY(-3px);
    box-shadow:0 8px 20px rgba(0,0,0,.25);
}

canvas{
    max-height:260px;
}

</style>

</div>

</x-app-layout>