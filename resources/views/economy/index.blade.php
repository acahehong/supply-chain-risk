<x-app-layout>

<div class="container-fluid">

    <h2 class="text-white fw-bold mb-4">
        📈 Economy Intelligence
    </h2>

    <div class="card bg-dark shadow">

        <div class="card-header text-white">

            Economy Data

        </div>

        <div class="card-body">

            <table class="table table-dark table-hover">

                <thead>

                    <tr>

                        <th>Country</th>
                        <th>GDP</th>
                        <th>Inflation</th>
                        <th>Population</th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($countries as $country)

                    <tr>

                        <td>{{ $country->name }}</td>

                        <td>
                            {{ number_format(optional($country->economicCache)->gdp ?? 0) }}
                        </td>

                        <td>
                            {{ optional($country->economicCache)->inflation ?? '-' }} %
                        </td>

                        <td>
                            {{ number_format(optional($country->economicCache)->population ?? 0) }}
                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

</div>

</x-app-layout>