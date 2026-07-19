<x-app-layout>

<div class="container-fluid py-4">

    {{-- HEADER --}}
    <div class="card border-0 shadow-lg mb-4"
         style="background:linear-gradient(135deg,#0f172a,#2563eb);border-radius:20px;">

        <div class="card-body d-flex justify-content-between align-items-center">

            <div>

                <h2 class="text-white fw-bold mb-1">
                    📰 Manage & Analysis Articles
                </h2>

                <p class="text-white-50 mb-0">
                    Manage all articles and monitor AI sentiment analysis.
                </p>

            </div>

            <div>

                <a href="{{ route('admin.dashboard') }}"
                   class="btn btn-light rounded-pill me-2">

                    ⬅ Dashboard

                </a>

                <a href="{{ route('admin.articles.create') }}"
                   class="btn btn-success rounded-pill">

                    ➕ Add Article

                </a>

            </div>

        </div>

    </div>

    {{-- STATISTIC --}}
    <div class="row g-4 mb-4">

        <div class="col-lg-3">

            <div class="card dashboard-card text-center">

                <div class="card-body">

                    <div style="font-size:42px">
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

                    <div style="font-size:42px">
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

                    <div style="font-size:42px">
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

                    <div style="font-size:42px">
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

    {{-- AI ANALYSIS & SEARCH --}}

<div class="row g-4 mb-4">

    <div class="col-lg-8">

        <div class="card dashboard-card">

            <div class="card-header">

                📈 AI Sentiment Analysis

            </div>

            <div class="card-body">

                <canvas id="sentimentChart" height="120"></canvas>

            </div>

        </div>

    </div>

    <div class="col-lg-4">

        <div class="card dashboard-card h-100">

            <div class="card-header">

                📊 Analysis Summary

            </div>

            <div class="card-body">

                <div class="d-flex justify-content-between mb-3">

                    <span>Total Articles</span>

                    <span class="badge bg-info">

                        {{ $total }}

                    </span>

                </div>

                <div class="d-flex justify-content-between mb-3">

                    <span>Positive</span>

                    <span class="badge bg-success">

                        {{ $positive }}

                    </span>

                </div>

                <div class="d-flex justify-content-between mb-3">

                    <span>Neutral</span>

                    <span class="badge bg-warning text-dark">

                        {{ $neutral }}

                    </span>

                </div>

                <div class="d-flex justify-content-between">

                    <span>Negative</span>

                    <span class="badge bg-danger">

                        {{ $negative }}

                    </span>

                </div>

            </div>

        </div>

    </div>

</div>

{{-- SEARCH --}}

<div class="card dashboard-card mb-4">

    <div class="card-body">

        <form method="GET"
              action="{{ route('admin.articles') }}">

            <div class="input-group">

                <input
                    type="text"
                    name="search"
                    class="form-control"
                    placeholder="🔍 Search article title..."
                    value="{{ request('search') }}">

                <button class="btn btn-info text-white">

                    Search

                </button>

                @if(request('search'))

                    <a href="{{ route('admin.articles') }}"
                       class="btn btn-secondary">

                        Reset

                    </a>

                @endif

            </div>

        </form>

    </div>

</div>

{{-- ARTICLE TABLE --}}

<div class="card dashboard-card">

    <div class="card-header d-flex justify-content-between align-items-center">

        <span>📰 Article List</span>

        <span class="badge bg-primary">

            {{ $articles->total() }} Articles

        </span>

    </div>

    <div class="card-body p-0">

        <div class="table-responsive">

            <table class="table table-dark table-hover align-middle mb-0">

                <thead class="table-header">

                    <tr>

                        <th width="60">#</th>

                        <th>Title</th>

                        <th>Category</th>

                        <th>Sentiment</th>

                        <th>Risk Score</th>

                        <th>Created</th>

                        <th width="170">Action</th>

                    </tr>

                </thead>

                <tbody>

                @forelse($articles as $article)

                    <tr>

                        <td>

                            {{ $loop->iteration }}

                        </td>

                        <td>

                            <div class="fw-bold">

                                {{ $article->title }}

                            </div>

                        </td>

                        <td>

                            <span class="badge bg-info">

                                {{ $article->category }}

                            </span>

                        </td>

                        <td>

                            @if($article->sentiment=='Positive')

                                <span class="badge bg-success">

                                    😊 Positive

                                </span>

                            @elseif($article->sentiment=='Neutral')

                                <span class="badge bg-warning text-dark">

                                    😐 Neutral

                                </span>

                            @else

                                <span class="badge bg-danger">

                                    😡 Negative

                                </span>

                            @endif

                        </td>

                        <td>

                            @if($article->risk_score >= 70)

                                <span class="badge bg-danger">

                                    {{ $article->risk_score }}

                                </span>

                            @elseif($article->risk_score >= 40)

                                <span class="badge bg-warning text-dark">

                                    {{ $article->risk_score }}

                                </span>

                            @else

                                <span class="badge bg-success">

                                    {{ $article->risk_score }}

                                </span>

                            @endif

                        </td>

                        <td>

                            {{ $article->created_at->format('d M Y') }}

                        </td>

                        <td>

                            <div class="d-flex gap-2">

                                <a href="{{ route('admin.articles.edit',$article) }}"
                                   class="btn btn-warning btn-sm rounded-pill">

                                    ✏ Edit

                                </a>

                                <form action="{{ route('admin.articles.destroy',$article) }}"
                                      method="POST">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        class="btn btn-danger btn-sm rounded-pill"
                                        onclick="return confirm('Delete this article?')">

                                        🗑 Delete

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="7"
                            class="text-center py-5 text-secondary">

                            No articles available.

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

<div class="mt-4">

    {{ $articles->withQueryString()->links() }}

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

.table td{
    color:white;
    border-color:#374151;
    padding:16px;
}

.table-header{
    background:#1e293b;
}

.table-header th{
    color:#38bdf8;
    border:none;
    padding:16px;
}

.form-control{
    background:#0f172a;
    color:white;
    border:1px solid #334155;
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

.pagination{
    justify-content:center;
}

</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

const ctx = document.getElementById('sentimentChart');

if(ctx){

new Chart(ctx,{

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
color:'white'
}

}

}

}

});

}

</script>

</x-app-layout>