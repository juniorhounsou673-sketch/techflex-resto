@extends('layouts.app')
@section('title', 'Commande #'.$order->id)
@section('content')

<div class="text-center mb-4">
    <div class="display-1">✅</div>
    <h2>Commande #{{ $order->id }} confirmée !</h2>
    <p class="text-muted">Merci {{ auth()->user()->name }}, votre commande est en cours de traitement.</p>
</div>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between mb-3">
                    <span>Statut :</span>
                    <span class="badge bg-warning px-3 py-2">{{ ucfirst($order->status) }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Livraison :</span>
                    <span>{{ $order->delivery_address }}</span>
                </div>
                @if($order->notes)
                <div class="d-flex justify-content-between mb-2">
                    <span>Notes :</span>
                    <span>{{ $order->notes }}</span>
                </div>
                @endif
                <hr>
                @foreach($order->items as $item)
                <div class="d-flex justify-content-between mb-1">
                    <span>{{ $item->menuItem->name }} × {{ $item->quantity }}</span>
                    <span>{{ number_format($item->unit_price * $item->quantity, 0, ',', ' ') }} FCFA</span>
                </div>
                @endforeach
                <hr>
                <div class="d-flex justify-content-between fw-bold fs-5">
                    <span>Total</span>
                    <span class="text-success">{{ number_format($order->total_amount, 0, ',', ' ') }} FCFA</span>
                </div>
            </div>
        </div>
        <div class="mt-3 d-flex gap-2">
            <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">Mes commandes</a>
            <a href="{{ route('menu.index') }}" class="btn btn-danger">Continuer à commander</a>
        </div>
    </div>
</div>

@endsection