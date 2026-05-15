<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $fillable = [
        'mediable_type',
        'mediable_id',
        'file_name',
        'file_path',
        'file_url',
        'disk',
        'mime_type',
        'file_size',
        'type',
        'collection',
        'thumbnail_url',
        'medium_url',
        'large_url',
        'width',
        'height',
        'metadata',
        'sort_order',
        'is_primary',
        'alt_text',
        'caption',
    ];

    protected function casts(): array
    {
        return [
            'metadata'   => 'array',
            'is_primary' => 'boolean',
        ];
    }

    public function mediable()
    {
        return $this->morphTo();
    }

    public function isImage(): bool
    {
        return $this->type === 'image';
    }

    public function isDocument(): bool
    {
        return $this->type === 'document';
    }

    // Retorna la mejor URL disponible según el tamaño pedido
    public function getUrl(string $size = 'original'): string
    {
        return match($size) {
            'thumbnail' => $this->thumbnail_url ?? $this->file_url,
            'medium'    => $this->medium_url ?? $this->file_url,
            'large'     => $this->large_url ?? $this->file_url,
            default     => $this->file_url,
        };
    }
}


// ─── PAYMENT MODEL ────────────────────────────────────────────────────────────

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $fillable = [
        'auction_id',
        'buyer_id',
        'seller_id',
        'amount',
        'commission',
        'seller_amount',
        'stripe_payment_intent_id',
        'stripe_transfer_id',
        'stripe_charge_id',
        'status',
        'tracking_number',
        'shipping_carrier',
        'shipped_at',
        'delivered_at',
        'released_at',
        'payment_due_at',
        'release_due_at',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'amount'        => 'decimal:2',
            'commission'    => 'decimal:2',
            'seller_amount' => 'decimal:2',
            'shipped_at'    => 'datetime',
            'delivered_at'  => 'datetime',
            'released_at'   => 'datetime',
            'payment_due_at' => 'datetime',
            'release_due_at' => 'datetime',
        ];
    }

    public function auction(): BelongsTo
    {
        return $this->belongsTo(Auction::class);
    }

    public function buyer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function seller(): BelongsTo
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function isPending(): bool     { return $this->status === 'pending'; }
    public function isInEscrow(): bool    { return $this->status === 'captured'; }
    public function isShipped(): bool     { return $this->status === 'shipped'; }
    public function isDelivered(): bool   { return $this->status === 'delivered'; }
    public function isReleased(): bool    { return $this->status === 'released'; }
    public function isDisputed(): bool    { return $this->status === 'disputed'; }
}
