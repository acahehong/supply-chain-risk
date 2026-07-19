<x-app-layout>

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2 class="fw-bold mb-0">
            ✏️ Edit Article
        </h2>

        <a href="{{ route('admin.articles') }}"
           class="btn btn-outline-secondary">

            ← Back to Articles

        </a>

    </div>

    @if ($errors->any())

        <div class="alert alert-danger">

            <ul class="mb-0">

                @foreach ($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif

    <div class="card shadow border-0">

        <div class="card-body">

            <form action="{{ route('admin.articles.update', $article) }}" method="POST">

                @csrf
                @method('PUT')

                <div class="mb-3">

                    <label class="form-label">
                        Title
                    </label>

                    <input
                        type="text"
                        name="title"
                        class="form-control"
                        value="{{ old('title', $article->title) }}"
                        required>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Category
                    </label>

                    <input
                        type="text"
                        name="category"
                        class="form-control"
                        value="{{ old('category', $article->category) }}"
                        required>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Content
                    </label>

                    <textarea
                        name="content"
                        rows="8"
                        class="form-control"
                        required>{{ old('content', $article->content) }}</textarea>

                </div>

                <button
                    type="submit"
                    class="btn btn-primary">

                    💾 Update Article

                </button>

                <a href="{{ route('admin.articles') }}"
                   class="btn btn-secondary">

                    Cancel

                </a>

            </form>

        </div>

    </div>

</div>

</x-app-layout>