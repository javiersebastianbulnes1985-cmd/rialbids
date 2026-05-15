<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Auction;

class CreateAuction extends Component
{
    public $title, $youtube_url, $base_price, $min_increment, $end_time;

    public function save()
    {
        $this->validate([
            'title' => 'required|min:3',
            'youtube_url' => 'required|url',
        ]);

        Auction::create([
            'title' => $this->title,
            'youtube_url' => $this->youtube_url,
            'base_price' => $this->base_price ?? 0,
            'min_increment' => $this->min_increment ?? 1,
            'end_time' => $this->end_time ?? now()->addDays(7),
        ]);

        return redirect()->to('/');
    }

    public function render()
    {
        return view('livewire.create-auction');
    }
}