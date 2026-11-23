<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'status',
        'total_amount',
        'notes',
        'delivery_address',
        'confirmed_at',
        'preparing_at',
        'ready_at',
        'delivered_at',
        'driver_name',
        'driver_phone',
        'estimated_delivery_at',
        'delivery_notes',
    ];

    protected function casts(): array
    {
        return [
            'confirmed_at' => 'datetime',
            'preparing_at' => 'datetime',
            'ready_at' => 'datetime',
            'delivered_at' => 'datetime',
            'estimated_delivery_at' => 'datetime',
        ];
    }

    public const STATUSES = [
        'pending',
        'confirmed',
        'preparing',
        'ready',
        'delivered',
        'cancelled',
    ];

    public const LABELS = [
        'pending' => 'En attente de confirmation',
        'confirmed' => 'Confirmée',
        'preparing' => 'En préparation',
        'ready' => 'En cours de livraison',
        'delivered' => 'Livrée',
        'cancelled' => 'Annulée',
    ];

    public const BADGES = [
        'pending' => 'bg-warning text-dark',
        'confirmed' => 'bg-info text-dark',
        'preparing' => 'bg-primary',
        'ready' => 'bg-secondary',
        'delivered' => 'bg-success',
        'cancelled' => 'bg-danger',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function paiements()
    {
        return $this->hasMany(Paiement::class);
    }

    public function statusLabel(): string
    {
        return self::LABELS[$this->status] ?? ucfirst($this->status);
    }

    public function statusBadge(): string
    {
        return self::BADGES[$this->status] ?? 'bg-secondary';
    }

    /**
     * Met à jour le statut et horodate automatiquement l'étape atteinte.
     */
    public function applyStatus(string $status): void
    {
        $timestamps = [
            'confirmed' => 'confirmed_at',
            'preparing' => 'preparing_at',
            'ready' => 'ready_at',
            'delivered' => 'delivered_at',
        ];

        $this->status = $status;

        if (isset($timestamps[$status]) && ! $this->{$timestamps[$status]}) {
            $this->{$timestamps[$status]} = now();
        }

        $this->save();
    }
}
