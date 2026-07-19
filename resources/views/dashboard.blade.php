<x-app-layout>

<style>

.favorite-card{
    border:none;
    border-radius:20px;
    background:linear-gradient(135deg,#fbc2d9,#f8cdda);
    color:#4a2c3a;
    box-shadow:0 15px 35px rgba(0,0,0,.15);
    transition:.3s;
}

.favorite-card .favorite-number{
    color:#ffffff !important;
}

.favorite-card h3{
    color:#ffffff !important;
}

.favorite-card .favorite-text{
    color:#ffffff !important;
}

    .favorite-card h3,
.favorite-card p,
.favorite-card .favorite-number{
    color:#fff;
}

.favorite-btn{
    background:#fff;
    color:#ec4899;
    border:none;
    font-weight:600;
}

.favorite-btn:hover{
    background:#fdf2f8;
    color:#be185d;
}

}

.favorite-card:hover{

    transform:translateY(-6px);

}

.favorite-number{

    font-size:60px;

    font-weight:bold;

    line-height:1;

}

.favorite-text{

    opacity:.9;

    font-size:18px;

}

.favorite-btn{

    border-radius:50px;

    padding:10px 30px;

    font-weight:bold;

}

</style>

<x-slot name="header">
<div class="d-flex justify-content-between align-items-center mb-4">

    <h2 class="fw-bold">
        🌍 Supply Chain Risk Intelligence Platform
    </h2>

    <div class="d-flex gap-2">

        <a href="{{ route('comparison') }}" class="btn btn-success">
            ⚖️ Country Comparison
        </a>

    </div>

<div>

<a href="{{ route('dashboard') }}" class="btn btn-primary">
Dashboard
</a>

<a href="{{ route('profile.edit') }}" class="btn btn-secondary">
Profile
</a>

<form action="{{ route('logout') }}" method="POST" class="d-inline">
    @csrf
    <button class="btn btn-danger">
        Logout
    </button>
</form>

</div>

</div>
</x-slot>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet"
href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>

<link rel="stylesheet"
href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.css">

<link rel="stylesheet"
href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.Default.css">

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>

body{
background:#f5f5f5;
}

.card{
border:none;
border-radius:15px;
}

#map{
height:600px;
border-radius:15px;
}

canvas{
max-height:350px;
}

</style>

<div class="container-fluid mt-4">

<div class="row">

    <div class="col-md-3 mb-3">
        <div class="card shadow">
            <div class="card-body text-center">
                <h6>🌍 Countries</h6>
                <h2 class="text-primary">{{ $totalCountries }}</h2>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card shadow">
            <div class="card-body text-center">
                <h6>⚓ Ports</h6>
                <h2 class="text-success">{{ $totalPorts }}</h2>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card shadow">
            <div class="card-body text-center">
                <h6>🌤 Weather</h6>
                <h2 class="text-info">{{ $totalWeather }}</h2>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card shadow">
            <div class="card-body text-center">
                <h6>📈 Economy</h6>
                <h2 class="text-warning">{{ $totalEconomy }}</h2>
            </div>
        </div>
    </div>

</div>

<div class="row">

    <div class="col-md-3 mb-3">
        <div class="card shadow">
            <div class="card-body text-center">
                <h6>💱 Currency</h6>
                <h2 class="text-secondary">{{ $totalCurrency }}</h2>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card shadow">
            <div class="card-body text-center">
                <h6>📰 News</h6>
                <h2 class="text-dark">{{ $totalNews }}</h2>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card shadow">
            <div class="card-body text-center">
                <h6>⚠ Risk Score</h6>
                <h2 class="text-danger">{{ $totalRisk }}</h2>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card shadow">
            <div class="card-body text-center">
                <h6>👤 User</h6>
                <h5>{{ auth()->user()->name }}</h5>
            </div>
        </div>
    </div>

</div>

<div class="row mt-4">

<div class="col-md-12">

<div class="card shadow">

<div class="card-body">

<h4>

🗺️ World Map

</h4>

<div id="map"></div>

<div class="card favorite-card mt-4">

    <div class="card-body text-center py-5">

        <div style="font-size:60px">
            ⭐
        </div>

        <div class="favorite-number">
            {{ auth()->user()->watchlists()->count() }}
        </div>

        <h3 class="mt-3 fw-bold">
            Favorite Monitoring
        </h3>

        <p class="favorite-text">
            Countries Saved
        </p>

        <a href="{{ route('watchlists.index') }}" class="btn btn-light favorite-btn">
            View Watchlist →
        </a>

    </div>

</div>

</div>

</div>

</div>

</div>

<div class="row mt-4">

<div class="col-md-6">

<div class="card shadow">

<div class="card-header">

Risk Score

</div>

<div class="card-body">

<canvas id="riskChart"></canvas>

</div>

</div>

</div>

<div class="col-md-6">

<div class="card shadow">

<div class="card-header">

GDP

</div>

<div class="card-body">

<canvas id="gdpChart"></canvas>

</div>

</div>

</div>

</div>

<div class="row mt-4">

<div class="col-md-6">

<div class="card shadow">

<div class="card-header">

Inflation

</div>

<div class="card-body">

<canvas id="inflationChart"></canvas>

</div>

</div>

</div>

<div class="col-md-6">

<div class="card shadow">

<div class="card-header">

Currency

</div>

<div class="card-body">

<canvas id="currencyChart"></canvas>

</div>

</div>

</div>

</div>

<div class="row mt-4">

    <div class="col-md-6">

        <div class="card shadow">

            <div class="card-header bg-success text-white">

                📦 Exports

            </div>

            <div class="card-body">

                <canvas id="exportChart"></canvas>

            </div>

        </div>

    </div>

    <div class="col-md-6">

        <div class="card shadow">

            <div class="card-header bg-warning">

                📥 Imports

            </div>

            <div class="card-body">

                <canvas id="importChart"></canvas>

            </div>

        </div>

    </div>

</div>

<!-- News Intelligence -->
<div class="row mt-4">
    <div class="col-md-12">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                📰 News Intelligence
            </div>

            <div class="card-body">

                @forelse($latestNews as $news)

                    <div class="border-bottom mb-3 pb-3">

                        <h6>
                            <a href="{{ $news->url }}"
                            target="_blank"
                            class="text-decoration-none">
                                {{ $news->title }}
                            </a>
                        </h6>

                        <p>
                            🌍 {{ $news->country->name ?? '-' }}
                        </p>

                        @if($news->sentiment_score > 0)

                            <span class="badge bg-success">
                                Positive
                            </span>

                        @elseif($news->sentiment_score < 0)

                            <span class="badge bg-danger">
                                Negative
                            </span>

                        @else

                            <span class="badge bg-secondary">
                                Neutral
                            </span>

                        @endif

                    </div>

                @empty

                    <div class="alert alert-warning">
                        No news available
                    </div>

                @endforelse

            </div>
        </div>
    </div>
</div>

<!-- Search -->
<div class="row mt-4">
    <div class="col-md-12">
        <div class="card shadow">

            <div class="card-header">
                Search
            </div>

            <div class="card-body">

                <div class="row">

                    <div class="col-md-6">
                        <input
                            type="text"
                            id="countrySearch"
                            class="form-control"
                            placeholder="Search Country">
                    </div>

                    <div class="col-md-6">
                        <input
                            type="text"
                            id="portSearch"
                            class="form-control"
                            placeholder="Search Port">
                    </div>

                </div>

            </div>

        </div>
    </div>
</div>

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script src="https://unpkg.com/leaflet.markercluster@1.5.3/dist/leaflet.markercluster.js"></script>


<script>

var map = L.map('map').setView([20,0],2);

L.tileLayer(
'https://tile.openstreetmap.org/{z}/{x}/{y}.png',
{
maxZoom:18,
attribution:'© OpenStreetMap'
}
).addTo(map);

var countryMarkers = [];
var portMarkers = [];

var portCluster = L.markerClusterGroup({
    showCoverageOnHover: false,
    spiderfyOnMaxZoom: true,
    disableClusteringAtZoom: 8
});

map.addLayer(portCluster);
var greenPort = L.icon({

iconUrl:'/icons/ship-green.svg',

iconSize:[40,40],

iconAnchor:[20,40],

popupAnchor:[0,-35]

});

var yellowPort = L.icon({

iconUrl:'/icons/ship-yellow.svg',

iconSize:[40,40],

iconAnchor:[20,40],

popupAnchor:[0,-35]

});

var redPort = L.icon({

iconUrl:'/icons/ship-red.svg',

iconSize:[40,40],

iconAnchor:[20,40],

popupAnchor:[0,-35]

});

@foreach ($countries as $country)

var marker = L.marker([
    {{ $country->latitude }},
    {{ $country->longitude }}
])
.addTo(map)
.bindPopup(`

<div style="min-width:250px">

<h5>🌍 {{ $country->name }}</h5>

<hr>

<b>🏛 Capital</b><br>
{{ $country->capital ?? '-' }}

<br><br>

<b>🌏 Region</b><br>
{{ $country->region ?? '-' }}

<br><br>

<b>🗣 Languages</b><br>
{{ $country->languages ?? '-' }}

<br><br>

<b>💰 Currency</b><br>
{{ $country->currency_name ?? '-' }}
({{ $country->currency_code ?? '-' }})

<hr>

<b>📈 GDP</b><br>
{{ number_format(optional($country->economicCache)->gdp ?? 0) }}

<br><br>

<b>📊 Inflation</b><br>
{{ optional($country->economicCache)->inflation ?? '-' }} %

<br><br>

<b>👥 Population</b><br>
{{ number_format(optional($country->economicCache)->population ?? 0) }}

<hr>

<form action="{{ route('watchlists.store',$country->id) }}" method="POST">

<input type="hidden" name="_token" value="{{ csrf_token() }}">

<button class="btn btn-warning btn-sm w-100">
⭐ Favorite
</button>

</form>

<br>

<a href="{{ route('comparison') }}?country1={{ $country->id }}"
class="btn btn-success btn-sm w-100">
📊 Compare
</a>

</div>

`)  

countryMarkers.push({

name:"{{ strtolower($country->name) }}",

marker:marker

});

@endforeach
@foreach($ports as $port)

@php

$icon='greenPort';

if($port->risk['level']=='MEDIUM'){
    $icon='yellowPort';
}

if($port->risk['level']=='HIGH'){
    $icon='redPort';
}

@endphp

var portMarker = L.marker(

[
{{ $port->latitude }},
{{ $port->longitude }}
],

{
icon:{{ $icon }}
}

)

.bindPopup(`

<h5>🚢 {{ $port->name }}</h5>

<b>🌍 Country</b>

<br>

{{ $port->country->name }}

<hr>

<b>🌡 Temperature</b>

<br>

{{ optional($port->weatherCache)->temperature ?? '-' }} °C

<br><br>

<b>💨 Wind Speed</b>

<br>

{{ optional($port->weatherCache)->wind_speed ?? '-' }} km/h

<br><br>

<b>🌧 Rainfall</b>

<br>

{{ optional($port->weatherCache)->precipitation ?? '-' }} mm

<br><br>

<b>⛈ Storm Risk</b>

<br>

@php
    $storm = optional($port->weatherCache)->storm_risk;
@endphp

@if($storm == 'High')

<span class="badge bg-danger">HIGH</span>

@elseif($storm == 'Medium')

<span class="badge bg-warning text-dark">MEDIUM</span>

@else

<span class="badge bg-success">LOW</span>

@endif

<br><br>

<b>🌤 Weather Code</b>

<br>

{{ optional($port->weatherCache)->weather_code ?? '-' }}

<hr>

<b>⚠ Risk Score</b>

<br>

<span class="badge bg-primary">

{{ $port->risk['score'] }}

</span>

<br><br>

<b>📊 Status</b>

<br>

@if($port->risk['level']=='HIGH')

<span class="badge bg-danger">HIGH</span>

@elseif($port->risk['level']=='MEDIUM')

<span class="badge bg-warning text-dark">MEDIUM</span>

@else

<span class="badge bg-success">LOW</span>

@endif

`);

portCluster.addLayer(portMarker);

portMarkers.push({

name:"{{ strtolower($port->name) }}",

marker:portMarker

});

@endforeach

const countrySearch = document.getElementById("countrySearch");

countrySearch.addEventListener("input", function () {

    const keyword = this.value.trim().toLowerCase();

    const found = countryMarkers.find(item => item.name.includes(keyword));

    if (found) {

        // Scroll ke peta
        document.getElementById("map").scrollIntoView({
            behavior: "smooth",
            block: "center"
        });

        setTimeout(() => {

            map.flyTo(found.marker.getLatLng(), 5);

            found.marker.openPopup();

        }, 500);

    

    }

});

const portSearch = document.getElementById("portSearch");

portSearch.addEventListener("input", function () {

    const keyword = this.value.trim().toLowerCase();

    const found = portMarkers.find(item => item.name.includes(keyword));

    if (found) {

        // Scroll ke peta
        document.getElementById("map").scrollIntoView({
            behavior: "smooth",
            block: "center"
        });

       setTimeout(() => {

    portCluster.zoomToShowLayer(found.marker, function () {

        map.flyTo(found.marker.getLatLng(), 7);

        found.marker.openPopup();

    });

}, 500);
    }

});
new Chart(document.getElementById('riskChart'),{

type:'bar',

data:{

labels:@json($chartLabels),

datasets:[{

label:'Risk Score',

data:@json($chartValues)

}]

}

});

new Chart(document.getElementById('gdpChart'),{

type:'bar',

data:{

labels:@json($gdpLabels),

datasets:[{

label:'GDP (Trillion)',

data:@json($gdpValues)

}]

}

});

new Chart(document.getElementById('inflationChart'),{

type:'line',

data:{

labels:@json($inflationLabels),

datasets:[{

label:'Inflation (%)',

data:@json($inflationValues)

}]

}

});

new Chart(document.getElementById('currencyChart'),{

type:'line',

data:{

labels:@json($currencyLabels),

datasets:[{

label:'Exchange Rate',

data:@json($currencyValues)

}]

}

});

new Chart(document.getElementById('exportChart'),{

type:'bar',

data:{

labels:@json($exportLabels),

datasets:[{

label:'Exports (Trillion USD)',

data:@json($exportValues)

}]

}

});

new Chart(document.getElementById('importChart'),{

type:'bar',

data:{

labels:@json($importLabels),

datasets:[{

label:'Imports (Trillion USD)',

data:@json($importValues)

}]

}

});

</script>

</div>

</x-app-layout>