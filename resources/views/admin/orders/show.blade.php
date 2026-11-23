@extends('layouts.admin')
@section('title', 'Commande #'.$order->id)
@section('content')

<div class="d-flex justify-content-between mb-4">
    <div>
        <h2 class="mb-1">Commande #{{ $order->id }}</h2>
        <span class="badge {{ $order->statusBadge() }}">{{ $order->statusLabel() }}</span>
        @if($order->driver_name)
            <span class="badge bg-dark">🛵 {{ $order->driver_name }}</span>
        @endif
    </div>
    <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">← Retour</a>
</div>

@if($order->status === 'pending')
<div class="alert alert-warning d-flex justify-content-between align-items-center">
    <div><strong>Commande en attente de confirmation.</strong> Vérifiez le paiement puis confirmez.</div>
    <form method="POST" action="{{ route('admin.orders.confirm', $order) }}">
        @csrf @method('PATCH')
        <button class="btn btn-success btn-sm">✔ Confirmer la commande</button>
    </form>
</div>
@endif

<div class="row">
    <div class="col-lg-7">
        <div class="card mb-3">
            <div class="card-body">
                <h5>Articles commandés</h5>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Plat</th>
                            <th>Qté</th>
                            <th>P.U.</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr>
                            <td>{{ $item->menuItem->name }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ number_format($item->unit_price, 0, ',', ' ') }} FCFA</td>
                            <td>{{ number_format($item->unit_price * $item->quantity, 0, ',', ' ') }} FCFA</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="fw-bold">
                            <td colspan="3">Total</td>
                            <td>{{ number_format($order->total_amount, 0, ',', ' ') }} FCFA</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-body">
                <h5>Paiement</h5>
                @forelse($order->paiements as $paiement)
                    <p class="mb-1">
                        <span class="badge {{ $paiement->statut === 'payé' ? 'bg-success' : 'bg-warning' }}">
                            {{ ucfirst($paiement->statut) }}
                        </span>
                        — {{ number_format($paiement->montant, 0, ',', ' ') }} FCFA
                        <small class="text-muted">({{ $paiement->methode }})</small>
                    </p>
                @empty
                    <p class="text-muted mb-0">Aucun paiement enregistré.</p>
                @endforelse
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-body">
                <h5>Suivi de livraison</h5>
                <ul class="list-unstyled mb-0">
                    @foreach($timeline as $field => $label)
                        <li class="d-flex gap-2 mb-2">
                            <span style="width:22px">{{ $order->{$field} ? '✅' : '⬜' }}</span>
                            <span>
                                <strong>{{ $label }}</strong>
                                @if($order->{$field})
                                    <small class="text-muted">— {{ $order->{$field}->format('d/m/Y H:i') }}</small>
                                @endif
                            </span>
                        </li>
                    @endforeach
                </ul>
                @if($order->estimated_delivery_at)
                    <div class="alert alert-light border mt-3 mb-0">
                        Livraison estimée : <strong>{{ $order->estimated_delivery_at->format('d/m/Y H:i') }}</strong>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="card mb-3">
            <div class="card-body">
                <h5>Informations client</h5>
                <p><strong>Client :</strong> {{ $order->user->name }}</p>
                <p><strong>Email :</strong> {{ $order->user->email }}</p>
                <p><strong>Adresse :</strong> {{ $order->delivery_address }}</p>
                @if($order->notes)
                    <p><strong>Notes :</strong> {{ $order->notes }}</p>
                @endif
                <p><strong>Date :</strong> {{ $order->created_at->format('d/m/Y à H:i') }}</p>
                <a href="{{ route('admin.users.show', $order->user) }}" class="btn btn-sm btn-outline-info">
                    Voir le client
                </a>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-body">
                <h5>Changer le statut</h5>
                <form method="POST" action="{{ route('admin.orders.status', $order) }}">
                    @csrf @method('PATCH')
                    <div class="mb-3">
                        <select name="status" class="form-select">
                            @foreach($statuses as $key => $label)
                                <option value="{{ $key }}" {{ $order->status === $key ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button class="btn btn-danger w-100">Mettre à jour</button>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h5>Livreur &amp; livraison</h5>
                <form method="POST" action="{{ route('admin.orders.delivery', $order) }}">
                    @csrf @method('PATCH')
                    <div class="mb-2">
                        <label class="form-label">Nom du livreur</label>
                        <input type="text" name="driver_name" class="form-control" value="{{ old('driver_name', $order->driver_name) }}">
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Téléphone du livreur</label>
                        <input type="text" name="driver_phone" class="form-control" value="{{ old('driver_phone', $order->driver_phone) }}">
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Livraison estimée</label>
                        <input type="datetime-local" name="estimated_delivery_at" class="form-control"
                               value="{{ old('estimated_delivery_at', $order->estimated_delivery_at?->format('Y-m-d\TH:i')) }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Note de livraison</label>
                        <textarea name="delivery_notes" class="form-control" rows="2">{{ old('delivery_notes', $order->delivery_notes) }}</textarea>
                    </div>
                    <button class="btn btn-outline-dark w-100">Enregistrer le suivi</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
