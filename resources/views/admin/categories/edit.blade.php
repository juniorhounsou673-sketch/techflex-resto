@extends('layouts.admin')
@section('title', 'Modifier catégorie')
@section('content')

<div class="d-flex justify-content-between mb-4">
    <h2>Modifier : {{ $category->name }}</h2>
    <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">← Retour</a>
</div>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <form method="POST" action="{{ route('admin.categories.update', $category) }}">
                    @csrf @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Nom de la catégorie *</label>
                        <input type="text" name="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $category->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="3">{{ old('description', $category->description) }}</textarea>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" name="is_active" class="form-check-input"
                            id="is_active" {{ $category->is_active ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">Catégorie active</label>
                    </div>
                    <button type="submit" class="btn btn-danger w-100">
                        <i class="bi bi-save"></i> Enregistrer les modifications
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection