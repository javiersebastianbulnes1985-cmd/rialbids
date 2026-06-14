<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dispute extends Model
{
    protected $fillable = [
        'auction_id', 'buyer_id', 'seller_id', 'reason',
        'description', 'photo_path', 'status', 'admin_resolution', 'resolved_at',
    ];

    protected $casts = [
        'resolved_at' => 'datetime',
    ];

    public function auction()
    {
        return $this->belongsTo(Auction::class);
    }

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function statusLabel(): string
    {
        return match ($this->status) {
            'abierta'            => 'Abierta',
            'en_revision'        => 'En revisión',
            'resuelta_comprador' => 'Resuelta a favor del comprador',
            'resuelta_vendedor'  => 'Resuelta a favor del vendedor',
            'cerrada'            => 'Cerrada',
            default              => ucfirst($this->status),
        };
    }
}
