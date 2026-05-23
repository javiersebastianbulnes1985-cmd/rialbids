<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Auction extends Model
{
    protected $fillable = [
        'title', 'slug', 'description', 'base_price', 'current_price',
        'reserve_price', 'buy_now_price', 'min_increment',
        'starts_at', 'end_time', 'status', 'user_id', 'category_id',
        'lot_category', 'video_url', 'technical_specs',
        'image_path', 'image_path_2', 'image_path_3', 'image_path_4', 'image_path_5', 'image_path_6', 'image_path_4', 'image_path_5', 'image_path_6',
        'total_bids', 'winner_id', 'final_price',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'end_time'  => 'datetime',
    ];

    public function bids()
    {
        return $this->hasMany(Bid::class)->orderBy('amount', 'desc');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getYoutubeId()
    {
        if (!$this->video_url) return null;
        preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?v=|embed\/|v\/))([^\?&\"'>]+)/", $this->video_url, $matches);
        return $matches[1] ?? null;
    }

    public function endTimestamp()
    {
        return $this->end_time ? $this->end_time->timestamp : 0;
    }

    public function endDateTime()
    {
        return $this->end_time;
    }

    public function nextMinimumBid()
    {
        return $this->current_price + ($this->min_increment ?? 1);
    }

    public function hasReserve()
    {
        return !empty($this->reserve_price) && $this->reserve_price > 0;
    }

    public function isReserveMet()
    {
        return $this->current_price >= $this->reserve_price;
    }

    public function hasBuyNow()
    {
        return !empty($this->buy_now_price) && $this->buy_now_price > 0;
    }

    public function isActive()
    {
        return $this->status === 'active' && ($this->end_time > now());
    }
}
