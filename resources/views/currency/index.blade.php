<x-app-layout>

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold text-white">
                💱 Currency Intelligence
            </h2>

            <p class="text-secondary mb-0">
                Real-time Exchange Rate Monitoring
            </p>

        </div>

        <a href="{{ route('currency.sync') }}" class="btn btn-success px-4">
            <i class="bi bi-arrow-repeat"></i>
            Sync Currency
        </a>

    </div>

    {{-- STATISTIC CARD --}}

    <div class="row mb-4">

        <div class="col-md-3">

            <div class="card bg-dark border-0 shadow-lg">

                <div class="card-body">

                    <small class="text-secondary">
                        Countries
                    </small>

                    <h2 class="text-info">
                        {{ $currencies->count() }}
                    </h2>

                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card bg-dark border-0 shadow-lg">

                <div class="card-body">

                    <small class="text-secondary">
                        Base Currency
                    </small>

                    <h2 class="text-warning">
                        USD
                    </h2>

                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card bg-dark border-0 shadow-lg">

                <div class="card-body">

                    <small class="text-secondary">
                        Last Update
                    </small>

                    <h5 class="text-success">

                        {{ optional($currencies->first())->fetched_at
                        ? optional($currencies->first())->fetched_at->diffForHumans()
                        : '-' }}

                    </h5>

                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card bg-dark border-0 shadow-lg">

                <div class="card-body">

                    <small class="text-secondary">
                        Exchange Records
                    </small>

                    <h2 class="text-danger">

                        {{ $currencies->count() }}

                    </h2>

                </div>

            </div>

        </div>

    </div>

    {{-- TABLE --}}

    <div class="card bg-dark border-0 shadow-lg">

        <div class="card-header bg-transparent">

            <h5 class="text-white mb-0">

                Exchange Rate Table

            </h5>

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-dark table-hover align-middle">

                    <thead>

                        <tr>

                            <th>#</th>

                            <th>Country</th>

                            <th>Currency</th>

                            <th>Exchange Rate</th>

                            <th>Last Update</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($currencies as $currency)

                        <tr>

                            <td>{{ $loop->iteration }}</td>

                            <td>

                                {{ $currency->country->name }}

                            </td>

                            <td>

                                {{ $currency->target_currency }}

                            </td>

                            <td>

                                <span class="badge bg-success fs-6">

                                    {{ number_format($currency->exchange_rate,4) }}

                                </span>

                            </td>

                            <td>

                                {{ $currency->fetched_at }}

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="5" class="text-center">

                                No Currency Data

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

<style>

body{

background:#0f172a;

}

.card{

background:#111827;

border-radius:18px;

}

.table{

margin-bottom:0;

}

.table thead{

background:#1f2937;

}

.table thead th{

border:none;

color:#38bdf8;

}

.table td{

border-color:#374151;

}

.btn-success{

border-radius:12px;

font-weight:600;

}

</style>

</x-app-layout>