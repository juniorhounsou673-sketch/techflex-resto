@extends('layouts.app')
@section('title', 'Mon Panier')
@section('content')

<h1 class="h3 mb-4"><i class="bi bi-cart3"></i> Mon Panier</h1>

@if(empty($cart))
    <div class="text-center py-5">
        <span class="display-1">🛒</span>
        <h3 class="mt-3">Votre panier est vide</h3>
        <a href="{{ route('menu.index') }}" class="btn btn-danger mt-2">Voir le menu</a>
    </div>
@else
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>Article</th>
                                <th>Prix unitaire</th>
                                <th>Quantité</th>
                                <th>Sous-total</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cart as $id => $item)
                            <tr>
                                <td>{{ $item['name'] }}</td>
                                <td>{{ number_format($item['price'], 0, ',', ' ') }} FCFA</td>
                                <td>
                                    <form method="POST" action="{{ route('cart.update', $id) }}" class="d-flex gap-1">
                                        @csrf @method('PATCH')
                                        <input type="number" name="quantity" value="{{ $item['quantity'] }}"
                                            min="0" class="form-control form-control-sm" style="width:70px">
                                        <button class="btn btn-sm btn-outline-secondary">Maj</button>
                                    </form>
                                </td>
                                <td><strong>{{ number_format($item['price'] * $item['quantity'], 0, ',', ' ') }} FCFA</strong></td>
                                <td>
                                    <form method="POST" action="{{ route('cart.remove', $id) }}">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Récapitulatif</h5>
                    <hr>
                    <div class="d-flex justify-content-between fs-5 fw-bold">
                        <span>Total</span>
                        <span class="text-success">{{ number_format($total, 0, ',', ' ') }} FCFA</span>
                    </div>
                    <div class="mt-3 d-grid gap-2">
                        @auth
                            <a href="{{ route('orders.checkout') }}" class="btn btn-success">
                                <i class="bi bi-check-circle"></i> Commander
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-warning">
                                Connectez-vous pour commander
                            </a>
                        @endauth
                        <a href="{{ route('menu.index') }}" class="btn btn-outline-secondary">
                            Continuer mes achats
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

@endsection