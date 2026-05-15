<?php

namespace App\Livewire;

use App\Models\Auction;
use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;

class AuctionCatalog extends Component
{
    use WithPagination;

    // ── Filtros ────────────────────────────────────────────────────────────────
    public string  $search        = '';
    public int     $categoryId    = 0;
    public string  $metal         = '';      // oro, plata, platino, titanio
    public string  $carats        = '';      // 9k, 14k, 18k, 24k
    public string  $gemstone      = '';      // diamante, rubi, esmeralda, zafiro, perla
    public int     $minPrice      = 0;
    public int     $maxPrice      = 0;
    public string  $sort          = 'ending';
    public bool    $hasVideo      = false;   // solo con YouTube
    public bool    $endingSoon    = false;   // menos de 1 hora
    public bool    $drawerOpen    = false;   // filtros en móvil

    // ── Query string sincronizado con la URL ───────────────────────────────────
    protected $queryString = [
        'search'     => ['except' => ''],
        'categoryId' => ['except' => 0],
        'metal'      => ['except' => ''],
        'carats'     => ['except' => ''],
        'gemstone'   => ['except' => ''],
        'minPrice'   => ['except' => 0],
        'maxPrice'   => ['except' => 0],
        'sort'       => ['except' => 'ending'],
        'hasVideo'   => ['except' => false],
        'endingSoon' => ['except' => false],
    ];

    // Resetear paginación cuando cambia cualquier filtro
    public function updatedSearch()     { $this->resetPage(); }
    public function updatedCategoryId() { $this->resetPage(); }
    public function updatedMetal()      { $this->resetPage(); }
    public function updatedCarats()     { $this->resetPage(); }
    public function updatedGemstone()   { $this->resetPage(); }
    public function updatedMinPrice()   { $this->resetPage(); }
    public function updatedMaxPrice()   { $this->resetPage(); }
    public function updatedSort()       { $this->resetPage(); }
    public function updatedHasVideo()   { $this->resetPage(); }
    public function updatedEndingSoon() { $this->resetPage(); }

    public function setCategory(int $id): void
    {
        $this->categoryId = $this->categoryId === $id ? 0 : $id;
        $this->resetPage();
    }

    public function clearFilters(): void
    {
        $this->reset([
            'search', 'categoryId', 'metal', 'carats',
            'gemstone', 'minPrice', 'maxPrice', 'hasVideo', 'endingSoon',
        ]);
        $this->sort = 'ending';
        $this->resetPage();
    }

    public function hasActiveFilters(): bool
    {
        return $this->search || $this->categoryId || $this->metal
            || $this->carats || $this->gemstone || $this->minPrice
            || $this->maxPrice || $this->hasVideo || $this->endingSoon;
    }

    public function render()
    {
        $query = Auction::active()
            ->with(['category', 'primaryImage', 'currentLeader'])
            ->withCount('bids');

        // ── Búsqueda de texto ──────────────────────────────────────────────────
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('title', 'LIKE', "%{$this->search}%")
                  ->orWhere('description', 'LIKE', "%{$this->search}%");
            });
        }

        // ── Categoría ──────────────────────────────────────────────────────────
        if ($this->categoryId) {
            $cat = Category::find($this->categoryId);
            if ($cat) {
                $ids = $cat->isParent()
                    ? $cat->children->pluck('id')->push($cat->id)
                    : collect([$cat->id]);
                $query->whereIn('category_id', $ids);
            }
        }

        // ── Filtros de ficha técnica (en columna JSON) ─────────────────────────
        if ($this->metal) {
            $query->whereJsonContains('technical_details->material', $this->metal)
                  ->orWhereRaw("JSON_EXTRACT(technical_details, '$.material') LIKE ?", ["%{$this->metal}%"]);
        }

        if ($this->carats) {
            $query->whereRaw("JSON_EXTRACT(technical_details, '$.quilates') LIKE ?", ["%{$this->carats}%"]);
        }

        if ($this->gemstone) {
            $query->whereRaw("JSON_EXTRACT(technical_details, '$.piedra') LIKE ?", ["%{$this->gemstone}%"]);
        }

        // ── Precio ─────────────────────────────────────────────────────────────
        if ($this->minPrice > 0) {
            $query->where('current_price', '>=', $this->minPrice);
        }
        if ($this->maxPrice > 0) {
            $query->where('current_price', '<=', $this->maxPrice);
        }

        // ── Solo con video ─────────────────────────────────────────────────────
        if ($this->hasVideo) {
            $query->whereNotNull('youtube_url');
        }

        // ── Terminando pronto ──────────────────────────────────────────────────
        if ($this->endingSoon) {
            $query->where('ends_at', '<=', now()->addHour());
        }

        // ── Ordenamiento ───────────────────────────────────────────────────────
        match ($this->sort) {
            'price_asc'  => $query->orderBy('current_price'),
            'price_desc' => $query->orderByDesc('current_price'),
            'newest'     => $query->orderByDesc('created_at'),
            'most_bids'  => $query->orderByDesc('total_bids'),
            default      => $query->orderBy('ends_at'),
        };

        $auctions   = $query->paginate(12);
        $categories = Category::active()->parents()
                               ->with('children')
                               ->orderBy('sort_order')
                               ->get();

        return view('livewire.auction-catalog', compact('auctions', 'categories'));
    }
}
