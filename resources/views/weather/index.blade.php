<x-app-layout>

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="text-white fw-bold">
                🌦 Weather Monitoring
            </h2>

            <p class="text-secondary mb-0">
                Real-Time Weather Information for All Ports
            </p>
        </div>

        <a href="{{ route('weather.sync') }}"
           class="btn btn-primary rounded-pill">

            <i class="bi bi-arrow-repeat"></i>

            Sync Weather

        </a>

    </div>

    <div class="row">

        <div class="col-lg-3 mb-4">

            <div class="card weather-card bg-primary text-white">

                <div class="card-body text-center">

                    <h1>⚓</h1>

                    <h2>{{ $totalPorts }}</h2>

                    <p>Total Ports</p>

                </div>

            </div>

        </div>

        <div class="col-lg-3 mb-4">

            <div class="card weather-card bg-success text-white">

                <div class="card-body text-center">

                    <h1>🌡</h1>

                    <h2>{{ $avgTemp }} °C</h2>

                    <p>Average Temperature</p>

                </div>

            </div>

        </div>

        <div class="col-lg-3 mb-4">

            <div class="card weather-card bg-info text-white">

                <div class="card-body text-center">

                    <h1>💨</h1>

                    <h2>{{ $avgWind }} km/h</h2>

                    <p>Average Wind</p>

                </div>

            </div>

        </div>

        <div class="col-lg-3 mb-4">

            <div class="card weather-card bg-danger text-white">

                <div class="card-body text-center">

                    <h1>⛈</h1>

                    <h2>{{ $highStorm }}</h2>

                    <p>High Storm Risk</p>

                </div>

            </div>

        </div>

    </div>

    <div class="card bg-dark border-0 shadow-lg">

        <div class="card-header bg-black text-white fw-bold">

            Weather Monitoring Table

        </div>

        <div class="card-body">

            <table class="table table-dark table-hover align-middle">

                <thead>

                <tr>

                    <th>Port</th>

                    <th>Country</th>

                    <th>Temperature</th>

                    <th>Wind</th>

                    <th>Weather Code</th>

                    <th>Last Update</th>

                </tr>

                </thead>

                <tbody>

                @forelse($ports as $port)

                    <tr>

                        <td>

                            {{ $port->name }}

                        </td>

                        <td>

                            {{ $port->country->name }}

                        </td>

                        <td>

                            {{ optional($port->weatherCache)->temperature ?? '-' }}

                            °C

                        </td>

                        <td>

                            {{ optional($port->weatherCache)->wind_speed ?? '-' }}

                            km/h

                        </td>

                        <td>

                            {{ optional($port->weatherCache)->weather_code ?? '-' }}

                        </td>

                        <td>

                            {{ optional($port->weatherCache)->fetched_at ?? '-' }}

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="6" class="text-center">

                            No Weather Data

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

<style>

.weather-card{

border:none;

border-radius:18px;

transition:.3s;

box-shadow:0 10px 25px rgba(0,0,0,.2);

}

.weather-card:hover{

transform:translateY(-6px);

}

.table{

border-radius:15px;

overflow:hidden;

}

.table thead{

background:#111827;

}

.table thead th{

color:white;

}

</style>

</x-app-layout>