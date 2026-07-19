<x-app-layout>

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2 class="fw-bold mb-0">
            ✏️ Edit User
        </h2>

        <a href="{{ route('admin.users') }}"
           class="btn btn-outline-secondary">

            ← Back to Users

        </a>

    </div>

    @if($errors->any())

        <div class="alert alert-danger">

            <ul class="mb-0">

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif

    <div class="card shadow border-0">

        <div class="card-body">

            <form action="{{ route('admin.users.update',$user) }}"
                  method="POST">

                @csrf
                @method('PUT')

                <div class="mb-3">

                    <label class="form-label">
                        Name
                    </label>

                    <input
                        type="text"
                        name="name"
                        class="form-control"
                        value="{{ old('name',$user->name) }}"
                        required>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Email
                    </label>

                    <input
                        type="email"
                        name="email"
                        class="form-control"
                        value="{{ old('email',$user->email) }}"
                        required>

                </div>

                <button
                    class="btn btn-primary">

                    💾 Update User

                </button>

                <a href="{{ route('admin.users') }}"
                   class="btn btn-secondary">

                    Cancel

                </a>

            </form>

        </div>

    </div>

</div>

</x-app-layout>