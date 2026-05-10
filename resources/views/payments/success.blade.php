@extends('layouts.app')
@section('title', 'Paiement confirmé')
@section('content')

<div class="row justify-content-center">
    <div class="col-md-6 text-center">

        <div class="mb-4">
            <div style="font-size:5rem">✅</div>
            <h2 class="fw-bold text-success">Paiement confirmé !</h2>
            <p class="text-muted">Votre paiement de <strong>{{ number_format($order->total_amount, 0, ',', ' ') }} FCFA</strong> a été reçu avec succès.</p>
        </div>

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Commande</span>
                    <strong>#{{ $order->id }}</strong>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Montant payé</span>
                    <strong class="text-success">{{ number_format($order->total_amount, 0, ',', ' ') }} FCFA</strong>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Mode de paiement</span>
                    <strong>📱 Mobile Money</strong>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Statut commande</span>
                    <span class="badge bg-success px-3 py-2">Confirmée ✅</span>
                </div>
                <div class="d-flex justify-content-between">
                    <span class="text-muted">Livraison</span>
                    <strong>{{ $order->delivery_address }}</strong>
                </div>
            </div>
        </div>

        <div class="alert alert-warning">
            <i class="bi bi-clock"></i>
            Votre commande est en cours de préparation. Temps estimé : <strong>30-45 minutes</strong>
        </div>

        <div class="d-flex gap-2 justify-content-center">
            <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-list"></i> Mes commandes
            </a>
            <a href="{{ route('menu.index') }}" class="btn btn-danger">
                <i class="bi bi-shop"></i> Retour au menu
            </a>
        </div>

    </div>
</div>

@endsection