<?php

namespace App\Http\Controllers;

use App\Models\Paiement;
use App\Models\Order;
use Illuminate\Http\Request;

class PaiementController extends Controller
{
    public function show(Order $order)
    {
        return view('payments.show', compact('order'));
    }

    public function store(Request $request, Order $order)
    {
        $request->validate([
            'telephone' => 'required|string|min:8|max:15',
            'operateur' => 'required|in:mtn,moov',
        ]);

        Paiement::create([
            'order_id' => $order->id,
            'methode' => 'mobile_money',
            'montant' => $order->total_amount,
            'statut' => 'payé',
        ]);

        $order->update(['status' => 'confirmed']);

        return redirect()->route('paiements.success', $order)
            ->with('success', 'Paiement effectué avec succès !');
    }

    public function success(Order $order)
    {
        return view('payments.success', compact('order'));
    }
}