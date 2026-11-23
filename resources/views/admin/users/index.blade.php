@extends('layouts.admin')
@section('title', 'Utilisateurs')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">Utilisateurs du site</h2>
    <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary btn-sm">📦 Commandes</a>
</div>

<form method="GET" class="row g-2 mb-3">
    <div class="col-auto">
        <select name="role" class="form-select" onchange="this.form.submit()">
            <option value="">Tous les rôles</option>
            <option value="user" {{ request('role') === 'user' ? 'selected' : '' }}>Clients</option>
            <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Administrateurs</option>
        </select>
    </div>
    @if(request()->filled('role'))
    <div class="col-auto">
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">Réinitialiser</a>
    </div>
    @endif
</form>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-dark">
                <tr>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Rôle</th>
                    <th>Commandes</th>
                    <th>Inscrit le</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <span class="badge {{ $user->isAdmin() ? 'bg-danger' : 'bg-primary' }}">
                            {{ $user->isAdmin() ? 'Admin' : 'Client' }}
                        </span>
                    </td>
                    <td>{{ $user->orders_count }}</td>
                    <td>{{ $user->created_at->format('d/m/Y') }}</td>
                    <td>
                        <a href="{{ route('admin.users.show', $user) }}" class="btn btn-sm btn-outline-primary">Voir</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted py-4">Aucun utilisateur.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $users->links() }}</div>

@endsection
