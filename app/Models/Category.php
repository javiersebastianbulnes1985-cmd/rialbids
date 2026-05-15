<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = [
        'parent_id',
        'name',
        'slug',
        'description',
        'image',
        'icon',
        'commission_rate',
        'is_active',
        'sort_order',
        'total_auctions',
    ];

    protected function casts(): array
    {
        return [
            'is_active'       => 'boolean',
            'commission_rate' => 'decimal:2',
        ];
    }

    // ─── RELATIONSHIPS ────────────────────────────────────────────────────────

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id')->orderBy('sort_order');
    }

    public function auctions(): HasMany
    {
        return $this->hasMany(Auction::class);
    }

    public function activeAuctions(): HasMany
    {
        return $this->hasMany(Auction::class)->where('status', 'active');
    }

    public function media()
    {
        return $this->morphMany(Media::class, 'mediable');
    }

    // ─── HELPERS ──────────────────────────────────────────────────────────────

    public function isParent(): bool
    {
        return is_null($this->parent_id);
    }

    public function getEffectiveCommissionRate(): float
    {
        // Si esta categoría no tiene comisión propia, usa la del padre
        if ($this->commission_rate) {
            return (float) $this->commission_rate;
        }
        if ($this->parent && $this->parent->commission_rate) {
            return (float) $this->parent->commission_rate;
        }
        // Fallback a la comisión global del config
        return (float) config('auction.commission_rate', 15.00);
    }

    // Scope para solo categorías activas
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope para solo categorías padre
    public function scopeParents($query)
    {
        return $query->whereNull('parent_id');
    }
}
