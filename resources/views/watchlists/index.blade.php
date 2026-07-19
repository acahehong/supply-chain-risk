<x-app-layout>

<div class="container py-4">

   <div class="container-fluid">

<div class="mb-4">

    <h2 class="text-white fw-bold">
        ⭐ My Watchlist
    </h2>

    <p class="text-secondary">
        Monitor countries that are important to your supply chain.
    </p>

</div>

<div class="row g-4 mb-4">

    <div class="col-md-3">

        <div class="card bg-primary border-0 shadow dashboard-card">

            <div class="card-body text-center">

                <h6 class="text-white">
                    TOTAL
                </h6>

                <h2 class="text-white fw-bold">
                    {{ $total }}
                </h2>

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card bg-danger border-0 shadow dashboard-card">

            <div class="card-body text-center">

                <h6 class="text-white">
                    HIGH RISK
                </h6>

                <h2 class="text-white fw-bold">
                    {{ $high }}
                </h2>

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card bg-warning border-0 shadow dashboard-card">

            <div class="card-body text-center">

                <h6>
                    MEDIUM
                </h6>

                <h2 class="fw-bold">
                    {{ $medium }}
                </h2>

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card bg-success border-0 shadow dashboard-card">

            <div class="card-body text-center">

                <h6 class="text-white">
                    LOW
                </h6>

                <h2 class="text-white fw-bold">
                    {{ $low }}
                </h2>

            </div>

        </div>

    </div>

</div>


    <!-- Tabel -->
   <div class="card dashboard-card shadow border-0">

    <div class="card-header">

        <h5 class="text-white mb-0">

            🌍 Watchlist Countries

        </h5>

    </div>

    <div class="card-body">

        @if($watchlists->count())

        <table class="table table-dark table-hover align-middle">

            <thead>

            <tr>

                <th>#</th>

                <th>Country</th>

                <th>Risk Score</th>

                <th>Status</th>

                <th>Updated</th>

                <th width="120">
                    Action
                </th>

            </tr>

            </thead>

            <tbody>

            @foreach($watchlists as $watchlist)

            @php

                $risk = optional($watchlist->country->riskScores->last());

            @endphp

            <tr>

                <td>

                    {{ $loop->iteration }}

                </td>

                <td>

                    <strong>

                        🌍 {{ $watchlist->country->name }}

                    </strong>

                </td>

                <td>

                    {{ number_format($risk->total_score ?? 0,1) }}

                </td>

                <td>

                    @if(($risk->risk_level ?? '') == 'High')

                        <span class="badge bg-danger">

                            HIGH

                        </span>

                    @elseif(($risk->risk_level ?? '') == 'Medium')

                        <span class="badge bg-warning text-dark">

                            MEDIUM

                        </span>

                    @else

                        <span class="badge bg-success">

                            LOW

                        </span>

                    @endif

                </td>

                <td>

                    {{ optional($risk->updated_at)->format('d M Y H:i') }}

                </td>

                <td>

                    <form
                        action="{{ route('watchlists.destroy',$watchlist->id) }}"
                        method="POST">

                        @csrf
                        @method('DELETE')

                        <button
                            class="btn btn-outline-danger btn-sm w-100">

                            Remove

                        </button>

                    </form>

                </td>

            </tr>

            @endforeach

            </tbody>

        </table>

        @else

        <div class="text-center py-5">

            <h1>

                ⭐

            </h1>

            <h4 class="text-white">

                Watchlist is Empty

            </h4>

            <p class="text-secondary">

                Add countries from Dashboard.

            </p>

            <a
                href="{{ route('dashboard') }}"
                class="btn btn-primary">

                Go Dashboard

            </a>

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

color:white;

border-color:#374151;

}

.btn-outline-danger{

border-radius:12px;

}

</style>

</x-app-layout>