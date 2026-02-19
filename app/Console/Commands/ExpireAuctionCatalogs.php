<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\AuctionCatalog;

class ExpireAuctionCatalogs extends Command
{
    protected $signature = 'auction:expire';
    protected $description = 'Auto-close katalog lelang yang sudah melewati tanggal lelang';

    public function handle(): void
    {
        $updated = AuctionCatalog::where('status', 'active')
            ->whereDate('auction_date', '<', today())
            ->update(['status' => 'closed']);

        if ($updated === 0) {
            $this->info('Tidak ada katalog yang perlu di-expire.');
            return;
        }

        $this->info("Selesai: {$updated} katalog di-update ke status 'closed'.");
    }
}
