<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bid extends Model
{
    protected $fillable = ['auction_id', 'user_id', 'amount', 'bidder_name', 'ip_address'];

    public function auction()
    {
        return $this->belongsTo(Auction::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Anonimiza el nombre para el historial público
     * Ejemplo: "Javier" -> "J***r"
     */
    public function anonymisedName()
    {
        $name = $this->bidder_name ?? ($this->user ? $this->user->name : 'Postor');
        $len = strlen($name);
        if ($len <= 2) return $name . "***";
        return substr($name, 0, 1) . str_repeat('*', 3) . substr($name, -1);
    }
}