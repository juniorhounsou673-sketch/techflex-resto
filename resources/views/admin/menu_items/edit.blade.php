@extends('layouts.admin')
@section('title', 'Modifier plat')
@section('content')

<div class="d-flex justify-content-between mb-4">
    <h2>Modifier : {{ $menuItem->name }}</h2>
    <a href="{{ route('admin.menu-items.index') }}" class="btn btn-outline-secondary">← Retour</a>
</div>

<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <form method="POST" action="{{ route('admin.menu-items.update', $menuItem) }}" enctype="multipart/form-data">
                    @csrf @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Catégorie *</label>
                        <select name="category_id" class="form-select" required>
                            <option value="">-- Choisir une catégorie --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id', $menuItem->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nom du plat *</label>
                        <input type="text" name="name" class="form-control"
                            value="{{ old('name', $menuItem->name) }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="3">{{ old('description', $menuItem->description) }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Prix (FCFA) *</label>
                        <input type="number" name="price" class="form-control"
                            value="{{ old('price', $menuItem->price) }}" min="0" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Image</label>
                        @if($menuItem->image)
                            <div class="mb-2">
                                <img src="{{ asset('storage/'.$menuItem->image) }}" height="80" class="rounded">
                            </div>
                        @endif
                        <input type="file" name="image" class="form-control" accept="image/*">
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" name="is_available" class="form-check-input"
                            id="is_available" {{ $menuItem->is_available ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_available">Disponible</label>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" name="is_featured" class="form-check-input"
                            id="is_featured" {{ $menuItem->is_featured ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_featured">Mettre en vedette ⭐</label>
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