<x-app-layout>

<div class="container-fluid py-4">

<div class="card border-0 shadow-lg mb-4"
style="background:linear-gradient(135deg,#0f766e,#14b8a6);border-radius:20px;">

<div class="card-body d-flex justify-content-between align-items-center">

<div>

<h2 class="text-white fw-bold mb-1">

⚓ Manage Ports

</h2>

<p class="text-white-50 mb-0">

Manage all ports connected to the Supply Chain Risk Monitor.

</p>

</div>

<a href="{{ route('admin.dashboard') }}"
class="btn btn-light rounded-pill">

⬅ Dashboard

</a>

</div>

</div>

<div class="row g-4 mb-4">

<div class="col-lg-3">

<div class="card dashboard-card text-center">

<div class="card-body">

<div style="font-size:42px;">⚓</div>

<h2 class="text-info fw-bold">

{{ $ports->total() }}

</h2>

<p class="text-secondary mb-0">

Total Ports

</p>

</div>

</div>

</div>

<div class="col-lg-3">

<div class="card dashboard-card text-center">

<div class="card-body">

<div style="font-size:42px;">🌍</div>

<h2 class="text-success fw-bold">

{{ $ports->pluck('country_id')->unique()->count() }}

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

<div style="font-size:42px;">🚢</div>

<h2 class="text-primary fw-bold">

{{ $ports->where('type','Seaport')->count() }}

</h2>

<p class="text-secondary mb-0">

Seaports

</p>

</div>

</div>

</div>

<div class="col-lg-3">

<div class="card dashboard-card text-center">

<div class="card-body">

<div style="font-size:42px;">✈</div>

<h2 class="text-warning fw-bold">

{{ $ports->where('type','Airport')->count() }}

</h2>

<p class="text-secondary mb-0">

Airports

</p>

</div>

</div>

</div>

</div>

<div class="card dashboard-card mb-4">

<div class="card-body">

<form method="GET">

<div class="input-group">

<input
type="text"
name="search"
value="{{ request('search') }}"
class="form-control"

placeholder="🔍 Search Port...">

<button class="btn btn-info text-white">

Search

</button>

</div>

</form>

</div>

</div>

<div class="card dashboard-card">

<div class="card-header">

⚓ Port List

</div>

<div class="card-body p-0">

<table class="table table-dark table-hover align-middle mb-0">

<thead class="table-header">

<tr>

<th width="60">#</th>

<th>Port</th>

<th>Country</th>

<th>Type</th>

</tr>

</thead>

<tbody>

@forelse($ports as $port)

<tr>

    <td>{{ $loop->iteration }}</td>

    <td class="fw-bold">
        {{ $port->name }}
    </td>

    <td>
        <span class="badge bg-primary">
            {{ $port->country->name }}
        </span>
    </td>

    <td>

        @if($port->type == 'Seaport')

            <span class="badge bg-success">
                🚢 Seaport
            </span>

        @else

            <span class="badge bg-warning text-dark">
                ✈ Airport
            </span>

        @endif

    </td>

</tr>

@empty

<tr>

    <td colspan="4" class="text-center py-4">

        No ports found.

    </td>

</tr>

@endforelse

</tbody>

</table>

<div class="p-3">

{{ $ports->withQueryString()->links() }}

</div>

</div>

</div>

</div>

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

.table{
    margin-bottom:0;
}

.table-header{
    background:#1e293b;
}

.table-header th{
    color:#38bdf8;
    border:none;
    padding:16px;
}

.table td{
    color:white;
    border-color:#374151;
    padding:16px;
}

.form-control{
    background:#0f172a;
    border:1px solid #334155;
    color:white;
}

.form-control:focus{
    background:#0f172a;
    color:white;
    border-color:#38bdf8;
    box-shadow:none;
}

.text-secondary{
    color:#cbd5e1 !important;
}

.badge{
    font-size:.85rem;
    padding:.55rem .8rem;
}

.btn{
    transition:.25s;
}

.btn:hover{
    transform:translateY(-2px);
}

</style>

</x-app-layout>