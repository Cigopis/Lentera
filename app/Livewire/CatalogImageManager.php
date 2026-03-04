<?php

namespace App\Livewire;

use App\Models\CatalogImage;
use App\Models\AuctionCatalog;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class CatalogImageManager extends Component
{
    public int    $catalogId;
    public string $gridMode        = 'main+3';
    public ?int   $confirmDeleteId = null;

    // State gambar disimpan sebagai array publik agar bisa di-dispatch ke Alpine
    public array $imageList = [];

    public function mount(): void
    {
        $this->loadImages();
    }

    private function loadImages(): void
    {
        $this->imageList = CatalogImage::where('catalog_id', $this->catalogId)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get()
            ->map(fn ($img) => [
                'id'         => $img->id,
                'url'        => asset('storage/' . $img->image_path),
                'is_primary' => (bool) $img->is_primary,
                'is_visible' => (bool) $img->is_visible,
                'sort_order' => (int)  $img->sort_order,
            ])
            ->values()
            ->toArray();
    }

    public function setGridMode(string $mode): void
    {
        $this->gridMode = $mode;

        AuctionCatalog::where('id', $this->catalogId)
            ->update(['grid_mode' => $mode]);
    }

    public function setPrimary(int $id): void
    {
        CatalogImage::where('catalog_id', $this->catalogId)->update(['is_primary' => false]);
        CatalogImage::where('id', $id)->update(['is_primary' => true]);
        $this->loadImages();
    }

    public function toggleVisibility(int $id): void
    {
        $visibleCount = CatalogImage::where('catalog_id', $this->catalogId)
            ->where('is_visible', true)->count();

        $img = CatalogImage::findOrFail($id);

        if ($img->is_visible && $visibleCount <= 1) return;

        $img->update(['is_visible' => !$img->is_visible]);

        // Jika primary disembunyikan, promosikan yang lain
        if (!$img->is_visible && $img->is_primary) {
            CatalogImage::where('catalog_id', $this->catalogId)
                ->where('id', '!=', $id)
                ->where('is_visible', true)
                ->orderBy('sort_order')
                ->first()
                ?->update(['is_primary' => true]);
        }

        $this->loadImages();
    }

    public function reorder(array $ids): void
    {
        foreach ($ids as $sort => $id) {
            CatalogImage::where('id', $id)
                ->where('catalog_id', $this->catalogId)
                ->update(['sort_order' => $sort + 1]);
        }
        $this->loadImages();
    }

    public function deleteConfirmed(): void
    {
        if (!$this->confirmDeleteId) return;

        $img = CatalogImage::where('id', $this->confirmDeleteId)
            ->where('catalog_id', $this->catalogId)
            ->firstOrFail();

        $wasPrimary = $img->is_primary;

        if (Storage::disk('public')->exists($img->image_path)) {
            Storage::disk('public')->delete($img->image_path);
        }

        $img->delete();

        if ($wasPrimary) {
            CatalogImage::where('catalog_id', $this->catalogId)
                ->orderBy('sort_order')
                ->first()
                ?->update(['is_primary' => true]);
        }

        $this->confirmDeleteId = null;
        $this->loadImages();
    }

    public function render()
    {
        return view('livewire.catalog-image-manager');
    }
}