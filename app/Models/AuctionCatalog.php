<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Traits\LogsModelActivity;

class AuctionCatalog extends Model
{
    use LogsModelActivity;
    use HasFactory;

    protected $fillable = [
        'catalog_code',
        'shop_number',
        'category_id',
        'sub_category_id',
        'city_id',
        'created_by',
        'title',
        'slug',
        'description',
        'reserve_price',
        'deposit_amount',
        'address',
        'auction_date',
        'official_auction_url',
        'status',
        'is_featured',
    ];

    protected $casts = [
        'auction_date' => 'date',
        'reserve_price' => 'decimal:2',
        'deposit_amount' => 'decimal:2',
        'is_featured' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function views()
    {
        return $this->hasMany(CatalogView::class, 'catalog_id');
    }


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($catalog) {
            // Auto-generate slug if not provided
            if (empty($catalog->slug)) {
                $catalog->slug = Str::slug($catalog->title);
            }
            
            // Auto-set created_by to current user
            if (empty($catalog->created_by) && auth()->check()) {
                $catalog->created_by = auth()->id();
            }
        });

        static::updating(function ($catalog) {
            // Auto-update slug if title changed
            if ($catalog->isDirty('title')) {
                $catalog->slug = Str::slug($catalog->title);
            }
        });
    }

    /**
     * Relasi ke Category
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relasi ke SubCategory
     */
    public function subCategory(): BelongsTo
    {
        return $this->belongsTo(SubCategory::class);
    }

    /**
     * Relasi ke City
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    /**
     * Relasi ke User (creator)
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Relasi ke CatalogImage
     */
    public function catalogImages(): HasMany
    {
        return $this->hasMany(CatalogImage::class, 'catalog_id');
    }

    /**
     * Get primary image
     */
    public function primaryImage()
    {
        return $this->hasOne(CatalogImage::class, 'catalog_id')
                    ->where('is_primary', true)
                    ->latest();
    }

    /**
     * Relasi ke AssetSpecification
     */
    public function specifications(): HasOne
    {
        return $this->hasOne(AssetSpecification::class, 'catalog_id');
    }

    /**
     * Relasi ke AssetFacility
     */
    public function facilities(): HasMany
    {
        return $this->hasMany(AssetFacility::class, 'catalog_id');
    }

    public function scopeFilter($query, $request)
    {
        if ($request->filled('kategori')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->kategori);
            });
        }

        if ($request->filled('min')) {
            $query->where('reserve_price', '>=', (int) $request->min);
        }

        if ($request->filled('max')) {
            $query->where('reserve_price', '<=', (int) $request->max);
        }

        if ($request->has('kota')) {

            $kota = array_filter((array) $request->kota);

            if (!empty($kota)) {
                $query->whereHas('city', function ($q) use ($kota) {
                    $q->whereIn('slug', $kota);
                });
            }
        }

        if ($request->filled('bulan')) {
            $query->whereMonth('auction_date', (int) $request->bulan);
        }

        return $query;
    }


    /**
     * Relasi ke ActivityLog
     */
    public function activityLogs(): HasMany
    {
        return $this->hasMany(ActivityLog::class, 'catalog_id');
    }

    /**
     * Scope untuk katalog aktif
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope untuk katalog unggulan
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope untuk katalog yang akan hilang (H-1 atau hari H)
     */
    public function scopeExpiringToday($query)
    {
        return $query->whereDate('auction_date', '=', Carbon::today())
                     ->orWhereDate('auction_date', '=', Carbon::tomorrow());
    }

    /**
     * Scope untuk katalog minggu ini
     */
    public function scopeUpcomingWeek($query)
    {
        return $query->whereBetween('auction_date', [
            Carbon::today(),
            Carbon::today()->addWeek()
        ]);
    }

    /**
     * Check if catalog is expiring soon (H-1 or today)
     */
    public function isExpiringSoon(): bool
    {
        if (!$this->auction_date) {
            return false;
        }

        $auctionDate = Carbon::parse($this->auction_date);
        $now = Carbon::now();
        $daysLeft = $now->diffInDays($auctionDate, false);

        return $daysLeft <= 1 && $daysLeft >= 0;
    }

    /**
     * Get days until auction
     */
    public function getDaysUntilAuction(): ?int
    {
        if (!$this->auction_date) {
            return null;
        }

        $auctionDate = Carbon::parse($this->auction_date);
        $now = Carbon::now();

        return $now->diffInDays($auctionDate, false);
    }

    /**
     * Get deadline status
     */
    public function getDeadlineStatus(): string
    {
        $daysLeft = $this->getDaysUntilAuction();

        if ($daysLeft === null) {
            return 'Tidak ada tanggal lelang';
        }

        if ($daysLeft < 0) {
            return 'Lelang sudah selesai';
        } elseif ($daysLeft == 0) {
            return 'HARI INI - Akan hilang dari listing';
        } elseif ($daysLeft == 1) {
            return 'BESOK (H-1) - Akan hilang dari listing';
        } elseif ($daysLeft <= 7) {
            return "{$daysLeft} hari lagi";
        } else {
            return "{$daysLeft} hari lagi";
        }
    }

    /**
     * Get formatted price
     */
    public function getFormattedReservePriceAttribute(): string
    {
        return 'Rp ' . number_format($this->reserve_price, 0, ',', '.');
    }

    /**
     * Get formatted deposit
     */
    public function getFormattedDepositAmountAttribute(): string
    {
        return 'Rp ' . number_format($this->deposit_amount, 0, ',', '.');
    }

    /**
     * Get status badge color
     */
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'draft' => 'gray',
            'active' => 'green',
            'closed' => 'red',
            default => 'gray',
        };
    }

    /**
     * Get status label
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'draft' => 'Draft',
            'active' => 'Tersedia',
            'closed' => 'Terjual/Tutup',
            default => $this->status,
        };
    }
}