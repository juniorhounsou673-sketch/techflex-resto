@extends('layouts.admin')
@section('title', 'Tableau de bord')
@section('content')

<h2 class="mb-4">Tableau de bord</h2>

<div class="row g-3 mb-4">
    <div class="col-sm-6 col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="fs-1 text-primary">📦</div>
                <div>
                    <div class="h4 mb-0">{{ $stats['total_orders'] }}</div>
                    <small class="text-muted">Total commandes</small>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="fs-1 text-warning">⏳</div>
                <div>
                    <div class="h4 mb-0">{{ $stats['pending_orders'] }}</div>
                    <small class="text-muted">À confirmer</small>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="fs-1 text-secondary">🛵</div>
                <div>
                    <div class="h4 mb-0">{{ $stats['delivering_orders'] }}</div>
                    <small class="text-muted">En cours de livraison</small>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="fs-1 text-success">✅</div>
                <div>
                    <div class="h4 mb-0">{{ $stats['delivered_orders'] }}</div>
                    <small class="text-muted">Livrées</small>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="fs-1 text-info">👥</div>
                <div>
                    <div class="h4 mb-0">{{ $stats['total_users'] }}</div>
                    <small class="text-muted">Clients</small>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="fs-1 text-success">💰</div>
                <div>
                    <div class="h4 mb-0">{{ number_format($stats['total_revenue'], 0, ',', ' ') }} FCFA</div>
                    <small class="text-muted">Chiffre d'affaires</small>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Dernières commandes</h4>
    <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-primary">Voir toutes les commandes</a>
</div>
<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
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
                @forelse($recent_orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->user->name }}</td>
                    <td>{{ number_format($order->total_amount, 0, ',', ' ') }} FCFA</td>
                    <td><span class="badge {{ $order->statusBadge() }}">{{ $order->statusLabel() }}</span></td>
                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-primary">Gérer</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted py-4">Aucune commande pour le moment.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
