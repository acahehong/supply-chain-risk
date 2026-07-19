<x-app-layout>

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2>
            <i class="bi bi-newspaper"></i>
            Latest Supply Chain News
        </h2>

        <a href="{{ route('news.sync') }}" class="btn btn-primary">
            <i class="bi bi-arrow-repeat"></i>
            Sync News
        </a>

    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @forelse($news as $article)

        <div class="card shadow-sm mb-3">

            <div class="card-body">

                <h5>{{ $article->title }}</h5>

                <p class="news-description">
                    {{ $article->description }}
                </p>

                <div class="d-flex justify-content-between">

                    <small>
                        🌍 {{ optional($article->country)->name }}
                    </small>

                    <small>
                        📰 {{ $article->source }}
                    </small>

                    <small>
                        {{ \Carbon\Carbon::parse($article->published_at)->format('d M Y') }}
                    </small>

                </div>

                <hr>

                <a href="{{ $article->url }}"
                   target="_blank"
                   class="btn btn-outline-primary btn-sm">

                    Read Full Article

                </a>

            </div>

        </div>

    @empty

        <div class="alert alert-warning">

            No news available.

        </div>

    @endforelse

    <div class="mt-4">

        {{ $news->links() }}

    </div>

</div>

<style>

body{
    background:#0f172a;
}

.card{
    background:#1e293b;
    border:none;
    border-radius:18px;
    color:white;
}

.card h5{
    color:white;
    font-weight:700;
}

.news-description{
    color:#cbd5e1;
    font-size:15px;
    line-height:1.7;
}

small{
    color:#cbd5e1;
}

hr{
    border-color:#334155;
}

.btn-outline-primary{
    border-radius:10px;
}

.pagination{
    justify-content:center;
}

.pagination .page-link{
    background:#1e293b;
    color:white;
    border:1px solid #334155;
}

.pagination .page-item.active .page-link{
    background:#2563eb;
    border-color:#2563eb;
}

</style>

</x-app-layout>