@extends('layouts.app')
@section('title', 'Finaliser la commande')
@section('content')

<div class="row justify-content-center">
    <div class="col-md-8">
        <h1 class="h3 mb-4">Finaliser la commande</h1>
        <div class="row">
            <div class="col-md-7">
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Informations de livraison</h5>
                        <form method="POST" action="{{ route('orders.store') }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Adresse de livraison *</label>
                                <input type="text" name="delivery_address"
                                    class="form-control @error('delivery_address') is-invalid @enderror"
                                    value="{{ old('delivery_address') }}" required>
                                @error('delivery_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Notes / Instructions (optionnel)</label>
                                <textarea name="notes" class="form-control" rows="3"
                                    placeholder="Ex : sonnette cassée, 2ème étage...">{{ old('notes') }}</textarea>
                            </div>
                            <button type="submit" class="btn btn-success w-100">
                                <i class="bi bi-check-circle"></i>
                                Confirmer la commande ({{ number_format($total, 0, ',', ' ') }} FCFA)
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Votre commande</h5>
                        @foreach($cart as $item)
                            <div class="d-flex justify-content-between mb-1">
                                <span>{{ $item['name'] }} × {{ $item['quantity'] }}</span>
                                <span>{{ number_format($item['price'] * $item['quantity'], 0, ',', ' ') }}</span>
                            </div>
                        @endforeach
                        <hr>
                        <div class="d-flex justify-content-between fw-bold">
                            <span>Total</span>
                            <span class="text-success">{{ number_format($total, 0, ',', ' ') }} FCFA</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection