<!DOCTYPE html>
<html>
<head>
    <title>Supply Chain Risk Monitor - Countries</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">
</head>
<body>

<div class="container mt-5">

    <h2 class="mb-4">
        🌍 Daftar Negara Supply Chain Monitor
    </h2>

    <table class="table table-bordered table-striped table-hover">
        <thead class="table-header-pink">
            <tr>
                <th>Flag</th>
                <th>Name</th>
                <th>Code</th>
                <th>Capital</th>
                <th>Region</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($countries as $country)
                <tr>
                    <td>
                        @if ($country->flag)
                            <img src="{{ $country->flag }}"
                                 width="50">
                        @endif
                    </td>

                    <td>{{ $country->name }}</td>
                    <td>{{ $country->code }}</td>
                    <td>{{ $country->capital }}</td>
                    <td>{{ $country->region }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</div>

</body>
</html>