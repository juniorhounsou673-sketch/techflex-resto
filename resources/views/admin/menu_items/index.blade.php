@extends('layouts.admin')
@section('title', 'Plats du menu')
@section('content')

<div class="d-flex justify-content-between mb-4">
    <h2>Plats du menu</h2>
    <a href="{{ route('admin.menu-items.create') }}" class="btn btn-danger">
        <i class="bi bi-plus-circle"></i> Nouveau plat
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Nom</th>
                    <th>Catégorie</th>
                    <th>Prix</th>
                    <th>Disponible</th>
                    <th>Vedette</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->category->name }}</td>
                    <td>{{ number_format($item->price, 0, ',', ' ') }} FCFA</td>
                    <td>
                        @if($item->is_available)
                            <span class="badge bg-success">Oui</span>
                        @else
                            <span class="badge bg-danger">Non</span>
                        @endif
                    </td>
                    <td>
                        @if($item->is_featured)
                            <span class="badge bg-warning">⭐ Oui</span>
                        @else
                            <span class="badge bg-secondary">Non</span>
                        @endif
                    </td>
                    <td class="d-flex gap-2">
                        <a href="{{ route('admin.menu-items.edit', $item) }}" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form method="POST" action="{{ route('admin.menu-items.destroy', $item) }}">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"
                                onclick="return confirm('Supprimer ce plat ?')">
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
{{ $items->links() }}

@endsection