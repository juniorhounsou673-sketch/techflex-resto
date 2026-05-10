@extends('layouts.app')
@section('title', 'Notre Menu')
@section('content')

<div class="row mb-4">
    <div class="col-12 text-center">
        <h1 class="display-5 fw-bold">Notre Menu</h1>
        <p class="lead text-muted">Découvrez nos spécialités du moment</p>
    </div>
</div>

@if($featured->count())
<section class="mb-5">
    <h2 class="h4 mb-3">⭐ Nos coups de cœur</h2>
    <div class="row g-3">
        @foreach($featured as $item)
        <div class="col-sm-6 col-md-4">
            <div class="card h-100 shadow-sm">
                <img src="{{ $item->image }}" class="card-img-top" alt="{{ $item->name }}" style="height:200px;object-fit:cover;">
                <div class="card-body">
                    <h5 class="card-title">{{ $item->name }}</h5>
                    <p class="card-text text-muted small">{{ Str::limit($item->description, 80) }}</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <strong class="text-success fs-5">{{ number_format($item->price, 0, ',', ' ') }} FCFA</strong>
                        <form method="POST" action="{{ route('cart.add', $item) }}">
                            @csrf
                            <button class="btn btn-danger btn-sm">
                                <i class="bi bi-cart-plus"></i> Ajouter
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>
@endif

@foreach($categories as $category)
@if($category->menuItems->count())
<section class="mb-5">
    <h2 class="h4 border-bottom pb-2 mb-3">{{ $category->name }}</h2>
    <div class="row g-3">
        @foreach($category->menuItems as $item)
        <div class="col-sm-6 col-lg-4">
            <div class="card h-100 shadow-sm">
                <img src="{{ $item->image }}" class="card-img-top" alt="{{ $item->name }}" style="height:200px;object-fit:cover;">
                <div class="card-body">
                    <h5 class="card-title">{{ $item->name }}</h5>
                    @if($item->description)
                        <p class="card-text text-muted small">{{ Str::limit($item->description, 80) }}</p>
                    @endif
                    <div class="d-flex justify-content-between align-items-center mt-2">
                        <strong class="text-success">{{ number_format($item->price, 0, ',', ' ') }} FCFA</strong>
                        <form method="POST" action="{{ route('cart.add', $item) }}">
                            @csrf
                            <button class="btn btn-outline-danger btn-sm">
                                <i class="bi bi-cart-plus"></i> Ajouter
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>
@endif
@endforeach

@endsection