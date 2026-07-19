<x-app-layout>

<div class="container-fluid">

    <div class="mb-4">
        <h2 class="text-white fw-bold">
            ⚠ Risk Analytics
        </h2>
        <p class="text-secondary">
            Global Supply Chain Risk Monitoring Dashboard
        </p>
    </div>

    <div class="row mb-4">

        <div class="col-md-4">
            <div class="card bg-danger text-white shadow border-0">
                <div class="card-body text-center">
                    <h6>HIGH RISK</h6>
                    <h1>{{ $high }}</h1>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card bg-warning shadow border-0">
                <div class="card-body text-center">
                    <h6>MEDIUM RISK</h6>
                    <h1>{{ $medium }}</h1>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card bg-success text-white shadow border-0">
                <div class="card-body text-center">
                    <h6>LOW RISK</h6>
                    <h1>{{ $low }}</h1>
                </div>
            </div>
        </div>

    </div>

    <div class="card bg-dark border-0 shadow">

        <div class="card-header">
            <h5 class="text-white mb-0">
                Country Risk Ranking
            </h5>
        </div>

        <div class="card-body">

            <table class="table table-dark table-hover">

                <thead>

                    <tr>
                        <th>No</th>
                        <th>Country</th>
                        <th>Risk Score</th>
                        <th>Status</th>
                    </tr>

                </thead>

                <tbody>

                @foreach($risks as $risk)

                    <tr>

                        <td>{{ $loop->iteration }}</td>

                       <td>{{ $risk->country->name }}</td>

                            <td>
                                {{ number_format($risk->total_score,2) }}
                            </td>

                        <td>

    @switch(strtolower($risk->risk_level))

        @case('high')
            <span class="badge bg-danger">HIGH</span>
            @break

        @case('medium')
            <span class="badge bg-warning text-dark">MEDIUM</span>
            @break

        @default
            <span class="badge bg-success">LOW</span>

    @endswitch

</td>

                    </tr>

                @endforeach

                </tbody>

            </table>

        </div>

    </div>

</div>

<style>

body{
    background:#0f172a;
}

.card{
    border-radius:18px;
}

.table thead{
    background:#1f2937;
}

.table th{
    color:#38bdf8;
}

</style>

</x-app-layout>