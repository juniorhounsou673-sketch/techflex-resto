<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    protected $fillable = ['order_id', 'methode', 'montant', 'statut'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}