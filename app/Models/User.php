<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'role',
        'name',
        'email',
        'password',
        'phone',
        'avatar',
        'address',
        'city',
        'state',
        'country',
        'postal_code',
        'kyc_status',
        'kyc_document_type',
        'kyc_document_front',
        'kyc_document_back',
        'kyc_verified_at',
        'kyc_rejection_reason',
        'stripe_customer_id',
        'stripe_account_id',
        'stripe_onboarding_complete',
        'is_active',
        'is_featured_seller',
        'bio',
        'business_name',
        'website',
        'total_auctions_won',
        'total_auctions_sold',
        'total_spent',
        'total_earned',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'stripe_customer_id',
        'stripe_account_id',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at'          => 'datetime',
            'kyc_verified_at'            => 'datetime',
            'stripe_onboarding_complete' => 'boolean',
            'is_active'                  => 'boolean',
            'is_featured_seller'         => 'boolean',
            'total_spent'                => 'decimal:2',
            'total_earned'               => 'decimal:2',
            'password'                   => 'hashed',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isSeller(): bool
    {
        return $this->role === 'seller';
    }

    public function isBidder(): bool
    {
        return $this->role === 'bidder';
    }

    public function isKycApproved(): bool
    {
        return $this->kyc_status === 'approved';
    }

    public function canBid(): bool
    {
        return $this->is_active && $this->hasVerifiedEmail();
    }

    public function canSell(): bool
    {
        return $this->is_active && $this->isSeller();
    }

    public function auctions()
    {
        return $this->hasMany(Auction::class);
    }

    public function activeAuctions()
    {
        return $this->hasMany(Auction::class)->where('status', 'active');
    }

    public function bids()
    {
        return $this->hasMany(Bid::class);
    }

    public function wonAuctions()
    {
        return $this->hasMany(Auction::class, 'winner_id');
    }

    public function watchedAuctions()
    {
        return $this->belongsToMany(Auction::class, 'auction_watchers')->withTimestamps();
    }

    public function purchases()
    {
        return $this->hasMany(Payment::class, 'buyer_id');
    }

    public function sales()
    {
        return $this->hasMany(Payment::class, 'seller_id');
    }

    public function auctionNotifications()
    {
        return $this->hasMany(AuctionNotification::class);
    }

    public function media()
    {
        return $this->morphMany(Media::class, 'mediable');
    }
}
