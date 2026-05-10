@extends('layouts.app')
@section('title', 'Paiement Mobile Money')
@section('content')

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="text-center mb-4">
            <h2>💳 Paiement Mobile Money</h2>
            <p class="text-muted">Commande #{{ $order->id }} — Total : <strong class="text-success">{{ number_format($order->total_amount, 0, ',', ' ') }} FCFA</strong></p>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <form method="POST" action="{{ route('paiements.store', $order) }}">
                    @csrf

                    <div class="mb-4">
                        <label class="form-label fw-bold">Choisir l'opérateur</label>
                        <div class="row g-3">
                            <div class="col-6">
                                <input type="radio" class="btn-check" name="operateur" id="mtn" value="mtn" required>
                                <label class="btn btn-outline-warning w-100 py-3" for="mtn">
                                    <div class="fw-bold fs-5">MTN</div>
                                    <small>Mobile Money</small>
                                </label>
                            </div>
                            <div class="col-6">
                                <input type="radio" class="btn-check" name="operateur" id="moov" value="moov">
                                <label class="btn btn-outline-primary w-100 py-3" for="moov">
                                    <div class="fw-bold fs-5">Moov</div>
                                    <small>Flooz</small>
                                </label>
                            </div>
                        </div>
                        @error('operateur')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Numéro de téléphone</label>
                        <div class="input-group">
                            <span class="input-group-text">+229</span>
                            <input type="text" name="telephone"
                                class="form-control form-control-lg @error('telephone') is-invalid @enderror"
                                placeholder="01 XX XX XX XX"
                                value="{{ old('telephone') }}" required>
                        </div>
                        @error('telephone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i>
                        Vous recevrez une notification sur votre téléphone pour confirmer le paiement de <strong>{{ number_format($order->total_amount, 0, ',', ' ') }} FCFA</strong>.
                    </div>

                    <button type="submit" class="btn btn-success w-100 py-3 fs-5">
                        <i class="bi bi-phone"></i> Confirmer le paiement
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection