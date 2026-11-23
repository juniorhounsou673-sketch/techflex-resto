@extends('layouts.admin')
@section('title', 'Utilisateur '.$user->name)
@section('content')

<div class="d-flex justify-content-between mb-4">
    <h2 class="mb-0">{{ $user->name }}</h2>
    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">← Retour</a>
</div>

<div class="card mb-4">
    <div class="card-body">
        <p><strong>Email :</strong> {{ $user->email }}</p>
        <p>
            <strong>Rôle :</strong>
            <span class="badge {{ $user->isAdmin() ? 'bg-danger' : 'bg-primary' }}">
                {{ $user->isAdmin() ? 'Administrateur' : 'Client' }}
            </span>
        </p>
        <p><strong>Inscrit le :</strong> {{ $user->created_at->format('d/m/Y à H:i') }}</p>
        <p><strong>Commandes :</strong> {{ $user->orders->count() }}</p>
    </div>
</div>

<h4 class="mb-3">Commandes de cet utilisateur</h4>
<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Total</th>
                    <th>Statut</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($user->orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                    <td>{{ number_format($order->total_amount, 0, ',', ' ') }} FCFA</td>
                    <td><span class="badge {{ $order->statusBadge() }}">{{ $order->statusLabel() }}</span></td>
                    <td>
                        <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-primary">Gérer</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-muted py-4">Aucune commande.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
