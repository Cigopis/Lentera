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
        'auction_time',
        'official_auction_url',
        'status',
        'is_featured',

        // Spesifikasi Properti
        'land_area',
        'building_area',
        'bedrooms',
        'bathrooms',
        'floors',
    ];

    protected $casts = [
        'auction_date'   => 'date',
        'reserve_price'  => 'decimal:2',
        'deposit_amount' => 'decimal:2',
        'is_featured'    => 'boolean',
        'created_at'     => 'datetime',
        'updated_at'     => 'datetime',
        'land_area'      => 'decimal:2',
        'building_area'  => 'decimal:2',
        'bedrooms'       => 'integer',
        'bathrooms'      => 'integer',
        'floors'         => 'integer',
    ];

    /*
    |--------------------------------------------------------------------------
    | STATUS CONSTANTS
    |--------------------------------------------------------------------------
    | draft   → belum dipublikasi
    | active  → aktif/tersedia, lelang sedang berjalan
    | sold    → TERJUAL — ada pemenang, tapi tanggal mungkin masih sisa
    | closed  → TUTUP   — lelang dibatalkan / ditutup tanpa pemenang
    |--------------------------------------------------------------------------
    */
    const STATUS_DRAFT  = 'draft';
    const STATUS_ACTIVE = 'active';
    const STATUS_SOLD   = 'sold';
    const STATUS_CLOSED = 'closed';

    public static function statusOptions(): array
    {
        return [
            self::STATUS_DRAFT  => 'Draft',
            self::STATUS_ACTIVE => 'Tersedia',
            self::STATUS_SOLD   => 'Terjual',
            self::STATUS_CLOSED => 'Tutup',
        ];
    }

    // -------------------------------------------------------------------------
    // Boot
    // -------------------------------------------------------------------------

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($catalog) {
            if (empty($catalog->slug)) {
                $catalog->slug = Str::slug($catalog->title);
            }

            if (empty($catalog->created_by) && auth()->check()) {
                $catalog->created_by = auth()->id();
            }
        });

        static::updating(function ($catalog) {
            if ($catalog->isDirty('title')) {
                $catalog->slug = Str::slug($catalog->title);
            }
        });
    }

    // -------------------------------------------------------------------------
    // Scopes
    // -------------------------------------------------------------------------

    public function scopeNotExpired($query)
    {
        return $query->where('auction_date', '>=', now()->toDateString());
    }

    /**
     * Hanya tampilkan di listing publik:
     * - status active (tersedia)
     * - status sold (terjual) selama tanggal belum lewat — biar pengunjung
     *   masih bisa melihat aset yang sudah ada pemenangnya
     * - tanggal belum lewat
     */
    public function scopePublished($query)
    {
        return $query->whereIn('status', [self::STATUS_ACTIVE, self::STATUS_SOLD])
                     ->where('auction_date', '>=', now()->toDateString());
    }

    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeExpiringToday($query)
    {
        return $query->whereDate('auction_date', '=', Carbon::today())
                     ->orWhereDate('auction_date', '=', Carbon::tomorrow());
    }

    public function scopeUpcomingWeek($query)
    {
        return $query->whereBetween('auction_date', [
            Carbon::today(),
            Carbon::today()->addWeek(),
        ]);
    }

    public function scopeFilter($query, $request)
    {
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%')
                  ->orWhere('address', 'like', '%' . $request->search . '%')
                  ->orWhereHas('category', function ($q2) use ($request) {
                      $q2->where('name', 'like', '%' . $request->search . '%');
                  });
            });
        }

        if ($request->filled('kategori')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->kategori);
            });
        }

        if ($request->filled('min')) {
            $query->where('reserve_price', '>=', (int) str_replace(['.', ','], ['', ''], $request->min));
        }

        if ($request->filled('max')) {
            $query->where('reserve_price', '<=', (int) str_replace(['.', ','], ['', ''], $request->max));
        }

        if ($request->filled('kota')) {
            $kota = $request->kota;
            $query->whereHas('city', function ($q) use ($kota) {
                if (is_array($kota)) {
                    $q->whereIn('slug', $kota);
                } else {
                    $q->where('slug', $kota);
                }
            });
        }

        if ($request->filled('bulan')) {
            $query->whereMonth('auction_date', (int) $request->bulan);
        }

        return $query;
    }

    // -------------------------------------------------------------------------
    // Relationships
    // -------------------------------------------------------------------------

    public function views()
    {
        return $this->hasMany(CatalogView::class, 'catalog_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function subCategory(): BelongsTo
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function catalogImages(): HasMany
    {
        return $this->hasMany(CatalogImage::class, 'catalog_id')
            ->orderBy('sort_order')
            ->orderBy('id');
    }

    public function visibleImages(): HasMany
    {
        return $this->hasMany(CatalogImage::class, 'catalog_id')
            ->where('is_visible', true)
            ->orderBy('sort_order')
            ->orderBy('id');
    }

    public function primaryImage()
    {
        return $this->hasOne(CatalogImage::class, 'catalog_id')
            ->where('is_primary', true)
            ->where('is_visible', true);
    }

    public function brochures()
    {
        return $this->hasMany(Brochure::class, 'auction_catalog_id');
    }

    public function specifications(): HasOne
    {
        return $this->hasOne(AssetSpecification::class, 'catalog_id');
    }

    public function facilities(): HasMany
    {
        return $this->hasMany(AssetFacility::class, 'catalog_id');
    }

    public function paymentProofs(): HasMany
    {
        return $this->hasMany(PaymentProof::class, 'catalog_id');
    }

    public function activityLogs(): HasMany
    {
        return $this->hasMany(ActivityLog::class, 'catalog_id');
    }

    // -------------------------------------------------------------------------
    // Helpers
    // -------------------------------------------------------------------------

    public function isExpiringSoon(): bool
    {
        if (!$this->auction_date) return false;

        $daysLeft = Carbon::today()->diffInDays(
            Carbon::parse($this->auction_date)->startOfDay(),
            false
        );

        return $daysLeft <= 1 && $daysLeft >= 0;
    }

    /** Selisih hari dari hari ini ke tanggal lelang (negatif jika sudah lewat) */
    public function getDaysUntilAuction(): ?int
    {
        if (!$this->auction_date) return null;

        return (int) Carbon::today()->diffInDays(
            Carbon::parse($this->auction_date)->startOfDay(),
            false
        );
    }

    public function getDeadlineStatus(): string
    {
        $daysLeft = $this->getDaysUntilAuction();

        if ($daysLeft === null) return 'Tidak ada tanggal lelang';

        $jamLabel = $this->auction_time
            ? ', ' . Carbon::parse($this->auction_time)->format('H.i') . ' WIB'
            : '';

        if ($daysLeft < 0)   return 'Lelang sudah ditutup';
        if ($daysLeft === 0) return 'Ditutup hari ini' . $jamLabel;
        if ($daysLeft === 1) return 'Besok' . $jamLabel;
        if ($daysLeft === 2) return 'Lusa' . $jamLabel;

        if ($daysLeft <= 7) {
            Carbon::setLocale('id');
            $tgl = $this->auction_date->translatedFormat('l, j M');
            return $tgl . $jamLabel;
        }

        return "Tutup {$daysLeft} hari lagi" . $jamLabel;
    }

    // -------------------------------------------------------------------------
    // Accessors
    // -------------------------------------------------------------------------

    public function getAuctionClosesAtAttribute(): ?Carbon
    {
        if (!$this->auction_date) return null;
        $time = $this->auction_time ?? '00:00';
        return Carbon::parse($this->auction_date->format('Y-m-d') . ' ' . $time);
    }

    public function getFormattedReservePriceAttribute(): string
    {
        return 'Rp ' . number_format($this->reserve_price, 0, ',', '.');
    }

    public function getFormattedDepositAmountAttribute(): string
    {
        return 'Rp ' . number_format($this->deposit_amount, 0, ',', '.');
    }

    public function getFormattedLandAreaAttribute(): string
    {
        return $this->land_area ? number_format($this->land_area, 0, ',', '.') . ' m²' : '-';
    }

    public function getFormattedBuildingAreaAttribute(): string
    {
        return $this->building_area ? number_format($this->building_area, 0, ',', '.') . ' m²' : '-';
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_DRAFT  => 'Draft',
            self::STATUS_ACTIVE => 'Tersedia',
            self::STATUS_SOLD   => 'Terjual',
            self::STATUS_CLOSED => 'Tutup',
            default             => $this->status,
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_DRAFT  => 'gray',
            self::STATUS_ACTIVE => 'green',
            self::STATUS_SOLD   => 'amber',
            self::STATUS_CLOSED => 'red',
            default             => 'gray',
        };
    }

    /** Apakah aset ini sudah terjual (status sold) */
    public function isSold(): bool
    {
        return $this->status === self::STATUS_SOLD;
    }

    /** Apakah aset ini ditutup/batal (status closed) */
    public function isClosed(): bool
    {
        return $this->status === self::STATUS_CLOSED;
    }

    /** Apakah aset ini tidak bisa ditawar lagi (sold atau closed) */
    public function isFinished(): bool
    {
        return in_array($this->status, [self::STATUS_SOLD, self::STATUS_CLOSED]);
    }
}