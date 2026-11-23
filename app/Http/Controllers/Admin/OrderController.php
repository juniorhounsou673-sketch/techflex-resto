<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::with('user')
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->status))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.orders.index', [
            'orders' => $orders,
            'statuses' => Order::LABELS,
            'currentStatus' => $request->status,
        ]);
    }

    public function show(Order $order)
    {
        $order->load('items.menuItem', 'user', 'paiements');

        return view('admin.orders.show', [
            'order' => $order,
            'statuses' => Order::LABELS,
            'timeline' => [
                'confirmed_at' => 'Confirmée',
                'preparing_at' => 'En préparation',
                'ready_at' => 'En cours de livraison',
                'delivered_at' => 'Livrée',
            ],
        ]);
    }

    public function confirm(Order $order)
    {
        if ($order->status !== 'pending') {
            return redirect()->back()->with('error', 'Seules les commandes en attente peuvent être confirmées.');
        }

        $order->applyStatus('confirmed');

        return redirect()->back()->with('success', 'Commande #'.$order->id.' confirmée.');
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:'.implode(',', Order::STATUSES),
        ]);

        $order->applyStatus($request->status);

        return redirect()->back()->with('success', 'Statut de la commande #'.$order->id.' mis à jour.');
    }

    public function updateDelivery(Request $request, Order $order)
    {
        $request->validate([
            'driver_name' => 'nullable|string|max:100',
            'driver_phone' => 'nullable|string|max:20',
            'estimated_delivery_at' => 'nullable|date',
            'delivery_notes' => 'nullable|string|max:500',
        ]);

        $order->update($request->only([
            'driver_name',
            'driver_phone',
            'estimated_delivery_at',
            'delivery_notes',
        ]));

        return redirect()->back()->with('success', 'Suivi de livraison mis à jour.');
    }
}
