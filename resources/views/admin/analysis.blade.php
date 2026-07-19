<x-app-layout>

<div class="container-fluid py-4">

    {{-- HEADER --}}
    <div class="card border-0 shadow-lg mb-4"
        style="background:linear-gradient(135deg,#0f172a,#1d4ed8);border-radius:20px;">

        <div class="card-body d-flex justify-content-between align-items-center">

            <div>

                <h2 class="text-white fw-bold mb-1">
                    📰 Analysis Articles
                </h2>

                <p class="text-white-50 mb-0">
                    AI Sentiment Analysis & News Monitoring Dashboard
                </p>

            </div>

            <a href="{{ route('admin.dashboard') }}"
               class="btn btn-light rounded-pill px-4 fw-bold">

                ⬅ Back to Admin

            </a>

        </div>

    </div>

    {{-- SUMMARY CARD --}}

    <div class="row g-4 mb-4">

        <div class="col-lg-3">

            <div class="card dashboard-card text-center">

                <div class="card-body">

                    <div style="font-size:45px">
                        📰
                    </div>

                    <h2 class="text-info fw-bold">

                        {{ $total }}

                    </h2>

                    <p class="text-secondary mb-0">

                        Total Articles

                    </p>

                </div>

            </div>

        </div>

        <div class="col-lg-3">

            <div class="card dashboard-card text-center">

                <div class="card-body">

                    <div style="font-size:45px">
                        😊
                    </div>

                    <h2 class="text-success fw-bold">

                        {{ $positive }}

                    </h2>

                    <p class="text-secondary mb-0">

                        Positive

                    </p>

                </div>

            </div>

        </div>

        <div class="col-lg-3">

            <div class="card dashboard-card text-center">

                <div class="card-body">

                    <div style="font-size:45px">
                        😐
                    </div>

                    <h2 class="text-warning fw-bold">

                        {{ $neutral }}

                    </h2>

                    <p class="text-secondary mb-0">

                        Neutral

                    </p>

                </div>

            </div>

        </div>

        <div class="col-lg-3">

            <div class="card dashboard-card text-center">

                <div class="card-body">

                    <div style="font-size:45px">
                        😡
                    </div>

                    <h2 class="text-danger fw-bold">

                        {{ $negative }}

                    </h2>

                    <p class="text-secondary mb-0">

                        Negative

                    </p>

                </div>

            </div>

        </div>

    </div>

    {{-- CHART & SEARCH --}}

    <div class="row g-4 mb-4">

        <div class="col-lg-5">

            <div class="card dashboard-card h-100">

                <div class="card-header">

                    📊 Sentiment Distribution

                </div>

                <div class="card-body">

                    <canvas id="sentimentChart" height="250"></canvas>

                </div>

            </div>

        </div>

        <div class="col-lg-7">

            <div class="card dashboard-card h-100">

                <div class="card-header">

                    🔍 Search Articles

                </div>

                <div class="card-body">

                    <form method="GET">

                        <div class="input-group">

                            <input
                                type="text"
                                name="search"
                                class="form-control"
                                value="{{ request('search') }}"
                                placeholder="Search article title...">

                            <button class="btn btn-primary">

                                Search

                            </button>

                        </div>

                    </form>

                    <hr class="border-secondary">

                    <h5 class="text-info">

                        AI Article Monitoring

                    </h5>

                    <p class="text-secondary">

                        This page displays all synchronized news articles
                        along with AI sentiment analysis results that help
                        identify supply chain risks worldwide.

                    </p>

                </div>

            </div>

        </div>

    </div>

    {{-- ARTICLE TABLE --}}

    <div class="card dashboard-card">

        <div class="card-header">

            📋 Article Analysis

        </div>

        <div class="card-body p-0">

            <table class="table table-dark table-hover align-middle mb-0">

                <thead class="table-header">

                    <tr>

                        <th width="60">#</th>

                        <th>Title</th>

                        <th>Country</th>

                        <th>Sentiment</th>

                        <th>Published</th>

                    </tr>

                </thead>

                <tbody>

                @forelse($articles as $article)

<tr>

    <td>

        {{ $loop->iteration }}

    </td>

    <td width="40%">

        <div class="fw-bold">

            {{ $article->title }}

        </div>

        @if($article->source)

            <small class="text-secondary">

                📰 {{ $article->source }}

            </small>

        @endif

    </td>

    <td>

        @if($article->country)

            <span class="badge bg-primary">

                {{ $article->country->name }}

            </span>

        @else

            <span class="badge bg-secondary">

                Unknown

            </span>

        @endif

    </td>

    <td>

        @if($article->sentiment=="Positive")

            <span class="badge bg-success">

                😊 Positive

            </span>

        @elseif($article->sentiment=="Negative")

            <span class="badge bg-danger">

                😡 Negative

            </span>

        @else

            <span class="badge bg-warning text-dark">

                😐 Neutral

            </span>

        @endif

    </td>

    <td>

        {{ \Carbon\Carbon::parse($article->published_at)->format('d M Y') }}

    </td>

</tr>

@empty

<tr>

    <td colspan="5" class="text-center py-5 text-secondary">

        No articles found.

    </td>

</tr>

@endforelse

</tbody>

</table>

<div class="p-3">

    {{ $articles->withQueryString()->links() }}

</div>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

new Chart(document.getElementById('sentimentChart'),{

    type:'doughnut',

    data:{

        labels:[
            'Positive',
            'Neutral',
            'Negative'
        ],

        datasets:[{

            data:[
                {{ $positive }},
                {{ $neutral }},
                {{ $negative }}
            ],

            backgroundColor:[
                '#22c55e',
                '#facc15',
                '#ef4444'
            ],

            borderWidth:0

        }]

    },

    options:{

        responsive:true,

        plugins:{

            legend:{

                position:'bottom',

                labels:{

                    color:'white',

                    font:{
                        size:13
                    }

                }

            }

        },

        cutout:'65%'

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