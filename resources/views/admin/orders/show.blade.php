@extends('layouts.admin')
@section('title', 'Commande #'.$order->id)
@section('content')

<div class="d-flex justify-content-between mb-4">
    <h2>Commande #{{ $order->id }}</h2>
    <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">← Retour</a>
</div>

<div class="row">
    <div class="col-md-7">
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
                            <td>{{ number_format($item->unit_price, 0, ',', ' ') }}</td>
                            <td>{{ number_format($item->unit_price * $item->quantity, 0, ',', ' ') }}</td>
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
    </div>
    <div class="col-md-5">
        <div class="card mb-3">
            <div class="card-body">
                <h5>Informations</h5>
                <p><strong>Client :</strong> {{ $order->user->name }}</p>
                <p><strong>Email :</strong> {{ $order->user->email }}</p>
                <p><strong>Adresse :</strong> {{ $order->delivery_address }}</p>
                @if($order->notes)
                    <p><strong>Notes :</strong> {{ $order->notes }}</p>
                @endif
                <p><strong>Date :</strong> {{ $order->created_at->format('d/m/Y à H:i') }}</p>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h5>Changer le statut</h5>
                <form method="POST" action="{{ route('admin.orders.status', $order) }}">
                    @csrf @method('PATCH')
                    <div class="mb-3">
                        <select name="status" class="form-select">
                            @foreach(['pending','confirmed','preparing','ready','delivered','cancelled'] as $s)
                                <option value="{{ $s }}" {{ $order->status === $s ? 'selected' : '' }}>
                                    {{ ucfirst($s) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button class="btn btn-danger w-100">Mettre à jour</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection