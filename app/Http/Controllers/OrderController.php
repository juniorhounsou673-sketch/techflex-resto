<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function checkout()
    {
        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Votre panier est vide.');
        }
        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
        return view('orders.checkout', compact('cart', 'total'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'delivery_address' => 'required|string|max:255',
            'notes' => 'nullable|string|max:500',
        ]);

        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('menu.index')->with('error', 'Panier vide.');
        }

        $total = collect($cart)->sum(fn($i) => $i['price'] * $i['quantity']);

        $order = Order::create([
            'user_id' => auth()->id(),
            'status' => 'pending',
            'total_amount' => $total,
            'notes' => $request->notes,
            'delivery_address' => $request->delivery_address,
        ]);

        foreach ($cart as $menuItemId => $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'menu_item_id' => $menuItemId,
                'quantity' => $item['quantity'],
                'unit_price' => $item['price'],
            ]);
        }

        session()->forget('cart');

        return redirect()->route('paiements.show', $order)
            ->with('success', 'Commande créée ! Veuillez procéder au paiement.');
    }

    public function show(Order $order)
    {
        if (auth()->id() !== $order->user_id) {
            abort(403);
        }
        $order->load('items.menuItem');
        return view('orders.show', compact('order'));
    }

    public function index()
    {
        $orders = auth()->user()->orders()->latest()->paginate(10);
        return view('orders.index', compact('orders'));
    }
}