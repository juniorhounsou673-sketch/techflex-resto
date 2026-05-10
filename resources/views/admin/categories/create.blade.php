@extends('layouts.admin')
@section('title', 'Nouvelle catégorie')
@section('content')

<div class="d-flex justify-content-between mb-4">
    <h2>Nouvelle catégorie</h2>
    <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">← Retour</a>
</div>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <form method="POST" action="{{ route('admin.categories.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Nom de la catégorie *</label>
                        <input type="text" name="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" name="is_active" class="form-check-input"
                            id="is_active" checked>
                        <label class="form-check-label" for="is_active">Catégorie active</label>
                    </div>
                    <button type="submit" class="btn btn-danger w-100">
                        <i class="bi bi-plus-circle"></i> Créer la catégorie
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection