@extends('layouts.app')
@section('title', $menuItem->name)
@section('content')

<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card shadow-sm">
            <img src="{{ $menuItem->image }}" class="card-img-top" alt="{{ $menuItem->name }}" style="height:320px;object-fit:cover;">
            <div class="card-body text-center">
                <h2>{{ $menuItem->name }}</h2>
                <p class="text-muted">{{ $menuItem->description }}</p>
                <h3 class="text-success">{{ number_format($menuItem->price, 0, ',', ' ') }} FCFA</h3>
                @unless(auth()->check() && auth()->user()->isAdmin())
                    <form method="POST" action="{{ route('cart.add', $menuItem) }}" class="mt-3">
                        @csrf
                        <button class="btn btn-danger">
                            <i class="bi bi-cart-plus"></i> Ajouter au panier
                        </button>
                    </form>
                @else
                    <div class="alert alert-info mt-3 mb-0">
                        Un compte administrateur ne peut pas passer de commande.
                    </div>
                @endunless
                <a href="{{ route('menu.index') }}" class="btn btn-outline-secondary mt-3">← Retour au menu</a>
            </div>
        </div>
    </div>
</div>

@endsection
