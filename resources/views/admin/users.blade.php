<x-app-layout>

<div class="container-fluid py-4">

<div class="card border-0 shadow-lg mb-4"
style="background:linear-gradient(135deg,#1e3a8a,#2563eb);border-radius:20px;">

<div class="card-body d-flex justify-content-between align-items-center">

<div>

<h2 class="text-white fw-bold mb-1">

👤 Manage Users

</h2>

<p class="text-white-50 mb-0">

Manage all registered users in the Supply Chain Risk Monitor System.

</p>

</div>

<div>

<a href="{{ route('admin.dashboard') }}"
class="btn btn-light rounded-pill me-2">

⬅ Dashboard

</a>

<a href="{{ route('admin.users.create') }}"
class="btn btn-success rounded-pill">

➕ Add User

</a>

</div>

</div>

</div>

<div class="row g-4 mb-4">

<div class="col-lg-4">

<div class="card dashboard-card text-center">

<div class="card-body">

<div style="font-size:45px;">👥</div>

<h2 class="text-info fw-bold">

{{ $users->count() }}

</h2>

<p class="text-secondary mb-0">

Total Users

</p>

</div>

</div>

</div>

<div class="col-lg-4">

<div class="card dashboard-card text-center">

<div class="card-body">

<div style="font-size:45px;">🛡️</div>

<h2 class="text-success fw-bold">

{{ $users->where('role','admin')->count() }}

</h2>

<p class="text-secondary mb-0">

Administrators

</p>

</div>

</div>

</div>

<div class="col-lg-4">

<div class="card dashboard-card text-center">

<div class="card-body">

<div style="font-size:45px;">👤</div>

<h2 class="text-warning fw-bold">

{{ $users->where('role','user')->count() }}

</h2>

<p class="text-secondary mb-0">

Normal Users

</p>

</div>

</div>

</div>

</div>

<div class="card dashboard-card shadow">

<div class="card-header">

📋 User List

</div>

<div class="card-body p-0">

<table class="table table-dark table-hover align-middle mb-0">

<thead class="table-header">

<tr>

<th width="60">#</th>

<th>Name</th>

<th>Email</th>

<th width="160">Created</th>

<th width="180">Action</th>

</tr>

</thead>

<tbody>

@foreach($users as $user)

<tr>

<td>{{ $loop->iteration }}</td>

<td class="fw-bold">

{{ $user->name }}

</td>

<td>

{{ $user->email }}

</td>

<td>

{{ $user->created_at->format('d M Y') }}

</td>

<td>

<div class="d-flex gap-2">

<a href="{{ route('admin.users.edit',$user) }}"
class="btn btn-warning btn-sm rounded-pill">

✏ Edit

</a>

<form
action="{{ route('admin.users.destroy',$user) }}"
method="POST">

@csrf

@method('DELETE')

<button
onclick="return confirm('Delete this user?')"
class="btn btn-danger btn-sm rounded-pill">

🗑 Delete

</button>

</form>

</div>

</td>

</tr>

@endforeach

</tbody>

</table>

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
    padding:16px 20px;
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
    font-weight:700;
}

.table td{
    color:white;
    border-color:#374151;
    padding:16px;
    vertical-align:middle;
}

.text-secondary{
    color:#cbd5e1 !important;
}

.btn{
    transition:.25s;
}

.btn:hover{
    transform:translateY(-2px);
}

.btn-warning{
    color:#000;
}

</style>

</div>

</x-app-layout>