<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SellerRequest extends Model
{
    protected $fillable = ['name', 'email', 'country', 'what_sells', 'status', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
