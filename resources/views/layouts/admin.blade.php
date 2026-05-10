<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin — @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        #sidebar { width: 240px; min-height: 100vh; background: #1a1a2e; }
        #sidebar a { color: #adb5bd; text-decoration: none; }
        #sidebar a:hover { color: #fff; background: rgba(255,255,255,.1); border-radius: 6px; }
        #content { flex: 1; background: #f8f9fa; }
    </style>
</head>
<body>
<div class="d-flex">
    <div id="sidebar" class="p-3">
        <h5 class="text-white mb-4 fw-bold">🍽️ Admin Panel</h5>
        <nav class="nav flex-column gap-1">
            <a href="{{ route('admin.dashboard') }}" class="nav-link px-2 py-2">
                <i class="bi bi-speedometer2 me-2"></i>Dashboard
            </a>
            <a href="{{ route('admin.categories.index') }}" class="nav-link px-2 py-2">
                <i class="bi bi-tags me-2"></i>Catégories
            </a>
            <a href="{{ route('admin.menu-items.index') }}" class="nav-link px-2 py-2">
                <i class="bi bi-menu-button-wide me-2"></i>Plats du menu
            </a>
            <a href="{{ route('admin.orders.index') }}" class="nav-link px-2 py-2">
                <i class="bi bi-bag-check me-2"></i>Commandes
            </a>
            <hr style="border-color: rgba(255,255,255,.2)">
            <a href="{{ route('home') }}" class="nav-link px-2 py-2">
                <i class="bi bi-arrow-left me-2"></i>Site public
            </a>
        </nav>
    </div>
    <div id="content" class="p-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @yield('content')
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>