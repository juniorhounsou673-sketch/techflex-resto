<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'delivering_orders' => Order::where('status', 'ready')->count(),
            'delivered_orders' => Order::where('status', 'delivered')->count(),
            'total_revenue' => Order::where('status', 'delivered')->sum('total_amount'),
            'total_users' => User::where('role', 'user')->count(),
        ];

        $recent_orders = Order::with('user')->latest()->take(10)->get();

        return view('admin.dashboard', compact('stats', 'recent_orders'));
    }
}
