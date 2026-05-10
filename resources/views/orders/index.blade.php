@extends('layouts.app')
@section('title', 'Mes commandes')
@section('content')

<h1 class="h3 mb-4">Mes commandes</h1>

@if($orders->count())
    <div class="card">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Total</th>
                        <th>Statut</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                        <td>{{ number_format($order->total_amount, 0, ',', ' ') }} FCFA</td>
                        <td>
                            <span class="badge bg-warning">{{ ucfirst($order->status) }}</span>
                        </td>
                        <td>
                            <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-outline-danger">
                                Voir
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-3">{{ $orders->links() }}</div>
@else
    <div class="text-center py-5">
        <span class="display-1">📦</span>
        <h3 class="mt-3">Aucune commande pour l'instant</h3>
        <a href="{{ route('menu.index') }}" class="btn btn-danger mt-2">Commander maintenant</a>
    </div>
@endif

@endsection