<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Paiement;
use Illuminate\Http\Request;

class PaiementController extends Controller
{
    public function show(Order $order)
    {
        $this->authorizeOwner($order);

        return view('payments.show', compact('order'));
    }

    public function store(Request $request, Order $order)
    {
        $this->authorizeOwner($order);

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

        // La commande reste « en attente » : seule l'administration la confirme.
        return redirect()->route('paiements.success', $order)
            ->with('success', 'Paiement enregistré ! Votre commande sera confirmée par le restaurant.');
    }

    public function success(Order $order)
    {
        $this->authorizeOwner($order);

        return view('payments.success', compact('order'));
    }

    private function authorizeOwner(Order $order): void
    {
        if (auth()->id() !== $order->user_id) {
            abort(403, 'Cette commande ne vous appartient pas.');
        }
    }
}
