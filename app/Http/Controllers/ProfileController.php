<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends \Illuminate\Routing\Controller
{
    public function index()
    {
        $user = auth()->user();
        $bids = \App\Models\Bid::with('auction')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('profile.index', compact('user', 'bids'));
    }
}
