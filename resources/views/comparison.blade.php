<x-app-layout>

<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="text-white fw-bold mb-1">
                🌍 Country Comparison
            </h2>

            <p class="text-secondary mb-0">
                Compare economic, weather, currency and supply chain risk between two countries.
            </p>
        </div>

        <a href="{{ route('dashboard') }}" class="btn btn-primary rounded-pill px-4">
            ⬅ Dashboard
        </a>

    </div>

    <div class="card dashboard-card shadow-lg border-0 mb-4">

        <div class="card-body">

            <form>

                <div class="row g-3 align-items-end">

                    <div class="col-md-5">

                        <label class="form-label text-info">
                            Country A
                        </label>

                        <select
                            name="country1"
                            class="form-select bg-dark text-white border-secondary">

                            <option value="">
                                Select Country
                            </option>

                            @foreach($countries as $country)

                                <option
                                    value="{{ $country->id }}"
                                    {{ request('country1')==$country->id?'selected':'' }}>

                                    {{ $country->name }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="col-md-5">

                        <label class="form-label text-info">
                            Country B
                        </label>

                        <select
                            name="country2"
                            class="form-select bg-dark text-white border-secondary">

                            <option value="">
                                Select Country
                            </option>

                            @foreach($countries as $country)

                                <option
                                    value="{{ $country->id }}"
                                    {{ request('country2')==$country->id?'selected':'' }}>

                                    {{ $country->name }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="col-md-2">

                        <button class="btn btn-info w-100 fw-bold">

                            🔍 Compare

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>

@if($data1 && $data2)

@php

$risk1 = optional($data1->riskScores->last())->total_score ?? 0;
$risk2 = optional($data2->riskScores->last())->total_score ?? 0;

@endphp

<div class="row g-4 mb-4">

    <div class="col-md-4">

        <div class="card dashboard-card border-0 shadow">

            <div class="card-body text-center">

                <small class="text-secondary">

                    Safer Country

                </small>

                <h3 class="fw-bold text-success mt-2">

                    {{ $risk1 < $risk2 ? $data1->name : $data2->name }}

                </h3>

            </div>

        </div>

    </div>

    <div class="col-md-4">

        <div class="card dashboard-card border-0 shadow">

            <div class="card-body text-center">

                <small class="text-secondary">

                    Higher GDP

                </small>

                <h3 class="fw-bold text-info mt-2">

                    {{
                    ($data1->economicCache->gdp ?? 0) >
                    ($data2->economicCache->gdp ?? 0)

                    ? $data1->name

                    : $data2->name
                    }}

                </h3>

            </div>

        </div>

    </div>

    <div class="col-md-4">

        <div class="card dashboard-card border-0 shadow">

            <div class="card-body text-center">

                <small class="text-secondary">

                    Lower Inflation

                </small>

                <h3 class="fw-bold text-warning mt-2">

                    {{
                    ($data1->economicCache->inflation ?? 0) <
                    ($data2->economicCache->inflation ?? 0)

                    ? $data1->name

                    : $data2->name
                    }}

                </h3>

            </div>

        </div>

    </div>

</div>

<div class="row g-4 mb-4">

<div class="col-lg-6">

<div class="card dashboard-card shadow border-0 h-100">

<div class="card-header bg-success bg-gradient text-white fw-bold">

🌍 {{ $data1->name }}

</div>

<div class="card-body">

<p><strong>GDP</strong><br>{{ number_format($data1->economicCache->gdp ?? 0) }}</p>

<p><strong>Inflation</strong><br>{{ $data1->economicCache->inflation ?? '-' }} %</p>

<p><strong>Population</strong><br>{{ number_format($data1->economicCache->population ?? 0) }}</p>

<p><strong>Temperature</strong><br>{{ optional($data1->ports->first()?->weatherCache)->temperature ?? '-' }} °C</p>

<p><strong>Wind Speed</strong><br>{{ optional($data1->ports->first()?->weatherCache)->wind_speed ?? '-' }} km/h</p>

<p><strong>Rainfall</strong><br>{{ optional($data1->ports->first()?->weatherCache)->precipitation ?? '-' }} mm</p>

<p>

<strong>Storm Risk</strong><br>

@php
$storm1 = optional($data1->ports->first()?->weatherCache)->storm_risk;
@endphp

@if($storm1=="High")
<span class="badge bg-danger">HIGH</span>
@elseif($storm1=="Medium")
<span class="badge bg-warning text-dark">MEDIUM</span>
@else
<span class="badge bg-success">LOW</span>
@endif

</p>

<p>

<strong>Risk Score</strong><br>

@if($risk1>=40)
<span class="badge bg-danger">HIGH</span>
@elseif($risk1>=20)
<span class="badge bg-warning text-dark">MEDIUM</span>
@else
<span class="badge bg-success">LOW</span>
@endif

<small class="text-secondary">
({{ $risk1 }})
</small>

</p>

<div class="progress mt-3" style="height:10px">

<div
class="progress-bar bg-danger"
style="width:{{ min($risk1,100) }}%">

</div>

</div>

</div>

</div>

</div>

<div class="col-lg-6">

<div class="card dashboard-card shadow border-0 h-100">

<div class="card-header bg-primary bg-gradient text-white fw-bold">

🌍 {{ $data2->name }}

</div>

<div class="card-body">

<p><strong>GDP</strong><br>{{ number_format($data2->economicCache->gdp ?? 0) }}</p>

<p><strong>Inflation</strong><br>{{ $data2->economicCache->inflation ?? '-' }} %</p>

<p><strong>Population</strong><br>{{ number_format($data2->economicCache->population ?? 0) }}</p>

<p><strong>Temperature</strong><br>{{ optional($data2->ports->first()?->weatherCache)->temperature ?? '-' }} °C</p>

<p><strong>Wind Speed</strong><br>{{ optional($data2->ports->first()?->weatherCache)->wind_speed ?? '-' }} km/h</p>

<p><strong>Rainfall</strong><br>{{ optional($data2->ports->first()?->weatherCache)->precipitation ?? '-' }} mm</p>

<p>

<strong>Storm Risk</strong><br>

@php
$storm2 = optional($data2->ports->first()?->weatherCache)->storm_risk;
@endphp

@if($storm2=="High")
<span class="badge bg-danger">HIGH</span>
@elseif($storm2=="Medium")
<span class="badge bg-warning text-dark">MEDIUM</span>
@else
<span class="badge bg-success">LOW</span>
@endif

</p>

<p>

<strong>Risk Score</strong><br>

@if($risk2>=40)
<span class="badge bg-danger">HIGH</span>
@elseif($risk2>=20)
<span class="badge bg-warning text-dark">MEDIUM</span>
@else
<span class="badge bg-success">LOW</span>
@endif

<small class="text-secondary">
({{ $risk2 }})
</small>

</p>

<div class="progress mt-3" style="height:10px">

<div
class="progress-bar bg-danger"
style="width:{{ min($risk2,100) }}%">

</div>

</div>

</div>

</div>

</div>

</div>
<div class="row g-4 mb-4">

    <div class="col-lg-6">

        <div class="card dashboard-card shadow border-0">

            <div class="card-header text-white fw-bold">

                📊 GDP Comparison

            </div>

            <div class="card-body">

                <canvas id="gdpCompareChart"></canvas>

            </div>

        </div>

    </div>

    <div class="col-lg-6">

        <div class="card dashboard-card shadow border-0">

            <div class="card-header text-white fw-bold">

                ⚠ Risk Score Comparison

            </div>

            <div class="card-body">

                <canvas id="riskCompareChart"></canvas>

            </div>

        </div>

    </div>

</div>

<div class="card dashboard-card shadow border-0">

    <div class="card-header">

        <h5 class="text-white mb-0">

            📋 Detail Comparison

        </h5>

    </div>

    <div class="card-body">

        <div class="table-responsive">

<table class="table table-dark table-hover align-middle">

<thead>

<tr>

<th>Indicator</th>

<th>{{ $data1->name }}</th>

<th>{{ $data2->name }}</th>

</tr>

</thead>

<tbody>

<tr>

<td>GDP</td>

<td>{{ number_format($data1->economicCache->gdp ?? 0) }}</td>

<td>{{ number_format($data2->economicCache->gdp ?? 0) }}</td>

</tr>

<tr>

<td>Inflation</td>

<td>{{ $data1->economicCache->inflation ?? '-' }} %</td>

<td>{{ $data2->economicCache->inflation ?? '-' }} %</td>

</tr>

<tr>

<td>Population</td>

<td>{{ number_format($data1->economicCache->population ?? 0) }}</td>

<td>{{ number_format($data2->economicCache->population ?? 0) }}</td>

</tr>

<tr>

<td>Capital</td>

<td>{{ $data1->capital ?? '-' }}</td>

<td>{{ $data2->capital ?? '-' }}</td>

</tr>

<tr>

<td>Region</td>

<td>{{ $data1->region ?? '-' }}</td>

<td>{{ $data2->region ?? '-' }}</td>

</tr>

<tr>

<td>Languages</td>

<td>{{ $data1->languages ?? '-' }}</td>

<td>{{ $data2->languages ?? '-' }}</td>

</tr>

<tr>

<td>Currency</td>

<td>{{ $data1->currency_code }} ({{ $data1->currency_name }})</td>

<td>{{ $data2->currency_code }} ({{ $data2->currency_name }})</td>

</tr>

<tr>

<td>Exchange Rate</td>

<td>{{ optional($data1->currencyCache)->exchange_rate ?? '-' }}</td>

<td>{{ optional($data2->currencyCache)->exchange_rate ?? '-' }}</td>

</tr>

<tr>

<td>Temperature</td>

<td>{{ optional($data1->ports->first()?->weatherCache)->temperature ?? '-' }} °C</td>

<td>{{ optional($data2->ports->first()?->weatherCache)->temperature ?? '-' }} °C</td>

</tr>

<tr>

<td>Wind Speed</td>

<td>{{ optional($data1->ports->first()?->weatherCache)->wind_speed ?? '-' }} km/h</td>

<td>{{ optional($data2->ports->first()?->weatherCache)->wind_speed ?? '-' }} km/h</td>

</tr>

<tr>

<td>Rainfall</td>

<td>{{ optional($data1->ports->first()?->weatherCache)->precipitation ?? '-' }} mm</td>

<td>{{ optional($data2->ports->first()?->weatherCache)->precipitation ?? '-' }} mm</td>

</tr>

<tr>

<td>Storm Risk</td>

<td>{{ optional($data1->ports->first()?->weatherCache)->storm_risk ?? '-' }}</td>

<td>{{ optional($data2->ports->first()?->weatherCache)->storm_risk ?? '-' }}</td>

</tr>

<tr>

<td>Risk Score</td>

<td>{{ $risk1 }}</td>

<td>{{ $risk2 }}</td>

</tr>

</tbody>

</table>

        </div>

    </div>

</div>

@endif

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@if($data1 && $data2)

<script>

new Chart(document.getElementById('gdpCompareChart'), {
    type: 'bar',
    data: {
        labels: [
            '{{ $data1->name }}',
            '{{ $data2->name }}'
        ],
        datasets: [{
            label: 'GDP',
            data: [
                {{ $data1->economicCache->gdp ?? 0 }},
                {{ $data2->economicCache->gdp ?? 0 }}
            ],
            backgroundColor: [
                '#22c55e',
                '#3b82f6'
            ]
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                labels: {
                    color: 'white'
                }
            }
        },
        scales: {
            x: {
                ticks: {
                    color: 'white'
                },
                grid: {
                    color: '#334155'
                }
            },
            y: {
                ticks: {
                    color: 'white'
                },
                grid: {
                    color: '#334155'
                }
            }
        }
    }
});

new Chart(document.getElementById('riskCompareChart'), {
    type: 'bar',
    data: {
        labels: [
            '{{ $data1->name }}',
            '{{ $data2->name }}'
        ],
        datasets: [{
            label: 'Risk Score',
            data: [
                {{ $risk1 }},
                {{ $risk2 }}
            ],
            backgroundColor: [
                '#ef4444',
                '#f59e0b'
            ]
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                labels: {
                    color: 'white'
                }
            }
        },
        scales: {
            x: {
                ticks: {
                    color: 'white'
                },
                grid: {
                    color: '#334155'
                }
            },
            y: {
                beginAtZero: true,
                max: 100,
                ticks: {
                    color: 'white'
                },
                grid: {
                    color: '#334155'
                }
            }
        }
    }
});

</script>

@endif

<style>

body{

background:#0f172a;

}

.dashboard-card{

background:#111827;

border-radius:18px;

}

.card-header{

background:#1e293b;

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

border-color:#374151;

color:white;

}

.form-select{

background:#0f172a;

color:white;

border:1px solid #334155;

}

.form-select:focus{

background:#0f172a;

color:white;

border-color:#38bdf8;

box-shadow:none;

}

.progress{

background:#374151;

border-radius:20px;

}

.progress-bar{

border-radius:20px;

}

</style>

</x-app-layout>