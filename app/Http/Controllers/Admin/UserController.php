<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::withCount('orders')
            ->when($request->filled('role'), fn ($query) => $query->where('role', $request->role))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        $user->load('orders.items.menuItem');

        return view('admin.users.show', compact('user'));
    }
}
