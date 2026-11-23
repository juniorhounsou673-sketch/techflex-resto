@extends('layouts.admin')
@section('title', 'Commandes')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">Toutes les commandes</h2>
    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary btn-sm">👥 Utilisateurs</a>
</div>

<form method="GET" class="row g-2 mb-3">
    <div class="col-auto">
        <select name="status" class="form-select" onchange="this.form.submit()">
            <option value="">Tous les statuts</option>
            @foreach($statuses as $key => $label)
                <option value="{{ $key }}" {{ $currentStatus === $key ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </select>
    </div>
    @if($currentStatus)
    <div class="col-auto">
        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">Réinitialiser</a>
    </div>
    @endif
</form>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Client</th>
                    <th>Total</th>
                    <th>Statut</th>
                    <th>Date</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>
                        {{ $order->user->name }}<br>
                        <small class="text-muted">{{ $order->user->email }}</small>
                    </td>
                    <td>{{ number_format($order->total_amount, 0, ',', ' ') }} FCFA</td>
                    <td><span class="badge {{ $order->statusBadge() }}">{{ $order->statusLabel() }}</span></td>
                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-primary">Gérer</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted py-4">Aucune commande.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $orders->links() }}</div>

@endsection
