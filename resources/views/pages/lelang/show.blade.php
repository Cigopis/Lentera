@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 md:px-6 pt-24 md:pt-28 pb-12">

    <script>
        function shareCatalog() {
            const url = "{{ $catalog->official_auction_url ?? url()->current() }}";
            const title = "{{ $catalog->title }}";

            if (navigator.share) {
                navigator.share({
                    title: title,
                    text: "Lihat detail aset lelang berikut:",
                    url: url
                });
            } else {
                navigator.clipboard.writeText(url);
                alert("Link berhasil disalin:\n" + url);
            }
        }

        async function downloadBrosur() {
            const canvas = document.getElementById('brosurCanvas');
            const ctx = canvas.getContext('2d');

            // Ukuran brosur (A5 landscape ratio)
            canvas.width  = 1200;
            canvas.height = 800;

            // ===== BACKGROUND =====
            const bg = ctx.createLinearGradient(0, 0, 1200, 800);
            bg.addColorStop(0, '#1e3a8a');
            bg.addColorStop(1, '#1e40af');
            ctx.fillStyle = bg;
            ctx.fillRect(0, 0, 1200, 800);

            // ===== ACCENT STRIP =====
            ctx.fillStyle = '#f59e0b';
            ctx.fillRect(0, 0, 8, 800);

            // ===== LOAD GAMBAR UTAMA =====
            const imgSrc = '{{ $catalog->primaryImage?->image_path ? asset("storage/".$catalog->primaryImage->image_path) : asset("img/default.jpg") }}';
            const img = new Image();
            img.crossOrigin = 'anonymous';

            await new Promise((resolve, reject) => {
                img.onload = resolve;
                img.onerror = reject;
                img.src = imgSrc;
            }).catch(() => {});

            // Gambar foto di sisi kiri
            if (img.complete && img.naturalWidth > 0) {
                // Clip ke rounded rect
                ctx.save();
                roundRect(ctx, 40, 40, 520, 720, 16);
                ctx.clip();
                
                // Cover fill
                const scale = Math.max(520 / img.width, 720 / img.height);
                const sw = img.width  * scale;
                const sh = img.height * scale;
                const sx = 40  + (520 - sw) / 2;
                const sy = 40  + (720 - sh) / 2;
                ctx.drawImage(img, sx, sy, sw, sh);
                ctx.restore();
            }

            // Overlay gelap di foto
            ctx.save();
            roundRect(ctx, 40, 40, 520, 720, 16);
            ctx.clip();
            const overlay = ctx.createLinearGradient(40, 40, 560, 760);
            overlay.addColorStop(0, 'rgba(0,0,0,0)');
            overlay.addColorStop(1, 'rgba(0,0,0,0.4)');
            ctx.fillStyle = overlay;
            ctx.fillRect(40, 40, 520, 720);
            ctx.restore();

            // ===== KONTEN KANAN =====
            const cx = 600; // x start konten kanan

            // Badge status
            ctx.fillStyle = '#10b981';
            roundRect(ctx, cx, 50, 140, 36, 18);
            ctx.fill();
            ctx.fillStyle = '#ffffff';
            ctx.font = 'bold 14px sans-serif';
            ctx.fillText('{{ $catalog->status_label }}', cx + 20, 73);

            // Label LELANG
            ctx.fillStyle = 'rgba(255,255,255,0.3)';
            ctx.font = '13px sans-serif';
            ctx.fillText('KATALOG LELANG', cx, 130);

            // Judul
            ctx.fillStyle = '#ffffff';
            ctx.font = 'bold 32px sans-serif';
            const title = '{{ addslashes($catalog->title) }}';
            wrapText(ctx, title, cx, 170, 560, 40);

            // Garis pemisah
            ctx.strokeStyle = '#f59e0b';
            ctx.lineWidth = 2;
            ctx.beginPath();
            ctx.moveTo(cx, 270);
            ctx.lineTo(cx + 560, 270);
            ctx.stroke();

            // Lokasi
            ctx.fillStyle = 'rgba(255,255,255,0.7)';
            ctx.font = '16px sans-serif';
            ctx.fillText('📍 {{ addslashes($catalog->city->name) }}', cx, 305);

            // Harga
            ctx.fillStyle = 'rgba(255,255,255,0.6)';
            ctx.font = '14px sans-serif';
            ctx.fillText('NILAI LIMIT', cx, 360);

            ctx.fillStyle = '#fbbf24';
            ctx.font = 'bold 36px sans-serif';
            ctx.fillText('{{ addslashes($catalog->formatted_reserve_price) }}', cx, 400);

            ctx.fillStyle = 'rgba(255,255,255,0.6)';
            ctx.font = '14px sans-serif';
            ctx.fillText('UANG JAMINAN', cx, 445);

            ctx.fillStyle = '#93c5fd';
            ctx.font = 'bold 28px sans-serif';
            ctx.fillText('{{ addslashes($catalog->formatted_deposit_amount) }}', cx, 480);

            // Tanggal
            ctx.fillStyle = 'rgba(255,255,255,0.6)';
            ctx.font = '14px sans-serif';
            ctx.fillText('BATAS PENAWARAN', cx, 530);

            ctx.fillStyle = '#ffffff';
            ctx.font = 'bold 20px sans-serif';
            ctx.fillText('{{ $catalog->auction_date->format("d F Y") }} — 23.00 WIB', cx, 558);

            // ===== FOOTER =====
            ctx.fillStyle = 'rgba(255,255,255,0.08)';
            ctx.fillRect(600, 680, 560, 80);

            ctx.fillStyle = 'rgba(255,255,255,0.9)';
            ctx.font = 'bold 18px sans-serif';
            ctx.fillText('Lentera Kertajaya', cx + 20, 715);

            ctx.fillStyle = 'rgba(255,255,255,0.5)';
            ctx.font = '13px sans-serif';
            ctx.fillText('lentera.id', cx + 20, 738);

            @if($catalog->official_auction_url)
            ctx.fillStyle = 'rgba(255,255,255,0.5)';
            ctx.font = '12px sans-serif';
            ctx.fillText('{{ addslashes($catalog->official_auction_url) }}', cx + 20, 755);
            @endif

            // ===== DOWNLOAD =====
            const link = document.createElement('a');
            link.download = 'brosur-{{ Str::slug($catalog->title) }}.png';
            link.href = canvas.toDataURL('image/png');
            link.click();
        }

        function roundRect(ctx, x, y, w, h, r) {
            ctx.beginPath();
            ctx.moveTo(x + r, y);
            ctx.lineTo(x + w - r, y);
            ctx.quadraticCurveTo(x + w, y, x + w, y + r);
            ctx.lineTo(x + w, y + h - r);
            ctx.quadraticCurveTo(x + w, y + h, x + w - r, y + h);
            ctx.lineTo(x + r, y + h);
            ctx.quadraticCurveTo(x, y + h, x, y + h - r);
            ctx.lineTo(x, y + r);
            ctx.quadraticCurveTo(x, y, x + r, y);
            ctx.closePath();
        }

        function wrapText(ctx, text, x, y, maxWidth, lineHeight) {
            const words = text.split(' ');
            let line = '';
            for (let i = 0; i < words.length; i++) {
                const test = line + words[i] + ' ';
                if (ctx.measureText(test).width > maxWidth && i > 0) {
                    ctx.fillText(line, x, y);
                    line = words[i] + ' ';
                    y += lineHeight;
                } else {
                    line = test;
                }
            }
            ctx.fillText(line, x, y);
        }
    </script>

    {{-- 
        Grid diratakan agar order bisa bekerja lintas kolom.
        Mobile: Gallery(1) → Sidebar(2) → Deskripsi(3) → Spesifikasi(4) → Fasilitas(5)
        Desktop: kiri col-span-2 (Gallery, Deskripsi, Spesifikasi, Fasilitas) | kanan (Sidebar sticky)
    --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 md:gap-8">

        {{-- ================= GALLERY ================= --}}
        {{-- Mobile: order 1 | Desktop: col-span-2 row 1 --}}
        <div class="lg:col-span-2 order-1"
            x-data="{ 
                images: [
                    @foreach($catalog->catalogImages as $image)
                        '{{ asset('storage/'.$image->image_path) }}',
                    @endforeach
                ],
                currentIndex: 0,
                showAll: false,
                open: false,
                get selectedImage() {
                    return this.images.length > 0 ? this.images[this.currentIndex] : '{{ $catalog->primaryImage?->image_path ? asset('storage/'.$catalog->primaryImage->image_path) : asset('img/default.jpg') }}';
                },
                prev() {
                    if (this.currentIndex > 0) this.currentIndex--;
                },
                next() {
                    if (this.currentIndex < this.images.length - 1) this.currentIndex++;
                },
                goTo(index) {
                    this.currentIndex = index;
                }
            }"
            class="bg-white border border-slate-200 rounded-2xl p-4"
        >
            {{-- MAIN IMAGE with arrows --}}
            <div class="relative overflow-hidden rounded-xl mb-4 cursor-pointer group"
                 @click="open = true">
                <img :src="selectedImage"
                     class="w-full h-[300px] md:h-[420px] object-cover transition duration-300 hover:scale-105">

                <div class="absolute inset-0 bg-gradient-to-t from-black/10 to-transparent pointer-events-none"></div>

                {{-- PREV BUTTON --}}
                <button
                    @click.stop="prev()"
                    class="absolute left-3 top-1/2 -translate-y-1/2 w-10 h-10 flex items-center justify-center rounded-full bg-white/80 backdrop-blur-sm shadow-md hover:bg-white transition opacity-0 group-hover:opacity-100"
                    x-show="images.length > 1 && currentIndex > 0"
                >
                    <svg class="w-5 h-5 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>

                {{-- NEXT BUTTON --}}
                <button
                    @click.stop="next()"
                    class="absolute right-3 top-1/2 -translate-y-1/2 w-10 h-10 flex items-center justify-center rounded-full bg-white/80 backdrop-blur-sm shadow-md hover:bg-white transition opacity-0 group-hover:opacity-100"
                    x-show="images.length > 1 && currentIndex < images.length - 1"
                >
                    <svg class="w-5 h-5 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>

                {{-- IMAGE COUNTER --}}
                <div class="absolute bottom-3 right-3 bg-black/50 text-white text-xs px-2.5 py-1 rounded-full backdrop-blur-sm"
                     x-show="currentIndex > 0">
                    <span x-text="currentIndex + 1"></span> / <span x-text="images.length"></span>
                </div>
            </div>

            {{-- THUMBNAILS --}}
            <div class="grid grid-cols-4 gap-3">
                @foreach($catalog->catalogImages as $index => $image)
                    <div 
                        x-show="showAll || {{ $index }} < 4"
                        class="overflow-hidden rounded-lg"
                    >
                        <img src="{{ asset('storage/'.$image->image_path) }}"
                             @click="goTo({{ $index }})"
                             :class="currentIndex === {{ $index }} ? 'ring-2 ring-blue-500 scale-105' : ''"
                             class="h-20 md:h-24 w-full object-cover cursor-pointer 
                                    hover:scale-105 transition duration-300 hover:opacity-90 rounded-lg">
                    </div>
                @endforeach
            </div>

            {{-- SHOW MORE BUTTON --}}
            @if($catalog->catalogImages->count() > 4)
                <div class="text-center mt-4">
                    <button @click="showAll = !showAll"
                            class="text-sm text-blue-600 font-semibold hover:underline">
                        <span x-show="!showAll">Lihat lebih banyak</span>
                        <span x-show="showAll">Tutup</span>
                    </button>
                </div>
            @endif

            {{-- POPUP MODAL --}}
            <div x-show="open"
                x-transition.opacity
                class="fixed inset-0 z-50 flex items-center justify-center bg-black/90 backdrop-blur-sm"
                @click.self="open = false"
                style="display: none;">

                <div class="relative w-full max-w-6xl px-6">

                    <img :src="selectedImage"
                        class="w-full h-auto max-h-[85vh] object-contain rounded-2xl shadow-2xl">

                    {{-- PREV in modal --}}
                    <button @click="prev()"
                            class="absolute left-0 top-1/2 -translate-y-1/2 w-12 h-12 flex items-center justify-center rounded-full bg-white/20 hover:bg-white/40 transition text-white"
                            x-show="currentIndex > 0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </button>

                    {{-- NEXT in modal --}}
                    <button @click="next()"
                            class="absolute right-0 top-1/2 -translate-y-1/2 w-12 h-12 flex items-center justify-center rounded-full bg-white/20 hover:bg-white/40 transition text-white"
                            x-show="currentIndex < images.length - 1">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>

                    <button @click="open = false"
                            class="absolute -top-10 right-0 text-white text-3xl hover:scale-110 transition">
                        ✕
                    </button>

                </div>
            </div>
        </div>
        {{-- ================= END GALLERY ================= --}}

        {{-- ================= RIGHT SIDEBAR ================= --}}
        {{-- Mobile: order 2 (setelah gallery) | Desktop: col kanan, membentang ke bawah --}}
        <div class="order-2 lg:row-span-4">
            <div class="bg-white border border-slate-200 rounded-2xl p-6 sticky top-24 shadow-md">

                {{-- STATUS BADGE --}}
                <div class="flex flex-wrap gap-2 mb-4">
                    <span class="px-3 py-1 text-xs rounded-full font-semibold bg-emerald-100 text-emerald-600">
                        {{ $catalog->status_label }}
                    </span>

                    @php $daysLeft = $catalog->getDaysUntilAuction(); @endphp

                    @if($daysLeft !== null && $daysLeft >= 0 && $daysLeft <= 7)
                        <span class="px-3 py-1 text-xs rounded-full font-semibold
                            {{ $daysLeft == 0 ? 'bg-red-100 text-red-600' : 
                            ($daysLeft == 1 ? 'bg-orange-100 text-orange-600' : 'bg-blue-100 text-blue-600') }}">
                            @if($daysLeft == 0)
                                HARI INI
                            @elseif($daysLeft == 1)
                                BESOK (H-1)
                            @else
                                {{ $daysLeft }} hari lagi
                            @endif
                        </span>
                    @endif
                </div>

                <p class="flex items-center gap-1.5 text-sm text-slate-400 mb-2">
                    <x-heroicon-s-map-pin class="w-4 h-4 shrink-0" />
                    {{ $catalog->city->name }}
                </p>

                {{-- JUDUL --}}
                <h1 class="text-lg md:text-xl font-semibold text-slate-800 mb-4 leading-snug">
                    {{ $catalog->title }}
                </h1>

                {{-- SHM / INFO TAMBAHAN --}}
                @if($catalog->shop_number)
                <div class="flex flex-col gap-1 mb-6">
                    <p class="text-sm text-slate-400">Bukti Kepemilikan</p>
                    <span class="px-3 py-1 text-xs rounded-lg border border-slate-200 bg-slate-50 w-fit">
                        {{ $catalog->shop_number }}
                    </span>
                </div>
                @endif

                {{-- NILAI LIMIT --}}
                <div class="mb-4">
                    <p class="text-sm text-slate-400">Nilai limit</p>
                    <p class="text-2xl font-bold text-red-600">
                        {{ $catalog->formatted_reserve_price }}
                    </p>
                </div>

                {{-- UANG JAMINAN --}}
                <div class="mb-4">
                    <p class="text-sm text-slate-400">Uang Jaminan</p>
                    <p class="text-xl font-bold text-blue-600">
                        {{ $catalog->formatted_deposit_amount }}
                    </p>
                </div>

                {{-- BATAS WAKTU --}}
                <div class="mb-6 space-y-2 text-sm text-slate-600">
                    <div>
                        <p class="text-slate-400">Batas Akhir Setor Uang Jaminan</p>
                        <p class="font-medium">
                            {{ $catalog->auction_date->subDay()->format('d F Y') }}
                        </p>
                    </div>

                    <div>
                        <p class="text-slate-400">Batas Akhir Penawaran</p>
                        <p class="font-medium">
                            {{ $catalog->auction_date->format('d F Y') }} 23.00 WIB
                        </p>
                    </div>
                </div>

                {{-- BUTTON AKSES LELANG --}}
                @if($catalog->official_auction_url)
                <a href="{{ $catalog->official_auction_url }}" target="_blank"
                   class="block w-full bg-blue-700 text-white text-center py-3 rounded-xl font-semibold hover:bg-blue-800 transition mb-4">
                    Akses Lelang Resmi
                </a>
                @endif

                <div class="flex gap-3 mb-4">
                    {{-- SHARE BUTTON --}}
                    <button
                        onclick="shareCatalog()"
                        class="flex items-center justify-center gap-2 flex-1 border border-slate-300 py-2 rounded-xl text-sm font-medium hover:bg-slate-50 transition">
                        <x-heroicon-o-share class="w-4 h-4" />
                        Bagikan
                    </button>

                    {{-- DOWNLOAD BROSUR --}}
                    <button
                        onclick="downloadBrosur()"
                        class="flex items-center justify-center gap-2 flex-1 border border-slate-300 py-2 rounded-xl text-sm font-medium text-center hover:bg-slate-50 transition">
                        <x-heroicon-o-arrow-down-tray class="w-4 h-4" />
                        Unduh Brosur
                    </button>

                    {{-- Hidden canvas untuk generate brosur --}}
                    <canvas id="brosurCanvas" style="display:none"></canvas>
                </div>

                <a href="https://wa.me/6285731599031?text=Saya%20tertarik%20dengan%20aset%20{{ urlencode($catalog->title) }}"
                   target="_blank"
                   class="flex items-center justify-center gap-2 w-full bg-green-600 text-white text-center py-3 rounded-xl font-semibold hover:bg-green-700 transition">
                    <x-heroicon-o-chat-bubble-left-ellipsis class="w-5 h-5" />
                    Hubungi Kami
                </a>

            </div>
        </div>
        {{-- ================= END SIDEBAR ================= --}}

        {{-- ================= DESKRIPSI ================= --}}
        {{-- Mobile: order 3 | Desktop: col-span-2 --}}
        <div class="lg:col-span-2 order-3 bg-white border border-slate-200 rounded-2xl p-6">
            <h3 class="text-base font-bold text-slate-800 mb-3">Deskripsi Aset</h3>
            <div class="text-slate-500 text-sm leading-relaxed">
                {!! $catalog->description !!}
            </div>
        </div>

        {{-- ================= SPESIFIKASI ================= --}}
        {{-- Mobile: order 4 | Desktop: col-span-2 --}}
        @if($catalog->specifications)
        <div class="lg:col-span-2 order-4 bg-white border border-slate-200 rounded-2xl p-6">
            <h3 class="text-base font-bold text-slate-800 mb-4">Spesifikasi Aset</h3>

            <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
                <div class="bg-blue-50 border border-blue-100 rounded-xl p-4">
                    <p class="text-xs text-slate-400 mb-1">Luas Tanah</p>
                    <p class="font-bold text-blue-600">
                        {{ $catalog->specifications->formatted_land_area }}
                    </p>
                </div>

                <div class="bg-blue-50 border border-blue-100 rounded-xl p-4">
                    <p class="text-xs text-slate-400 mb-1">Luas Bangunan</p>
                    <p class="font-bold text-blue-600">
                        {{ $catalog->specifications->formatted_building_area }}
                    </p>
                </div>

                <div class="bg-slate-50 border border-slate-100 rounded-xl p-4">
                    <p class="text-xs text-slate-400 mb-1">Kamar Tidur</p>
                    <p class="font-bold text-slate-700">
                        {{ $catalog->specifications->bedrooms }}
                    </p>
                </div>

                <div class="bg-slate-50 border border-slate-100 rounded-xl p-4">
                    <p class="text-xs text-slate-400 mb-1">Kamar Mandi</p>
                    <p class="font-bold text-slate-700">
                        {{ $catalog->specifications->bathrooms }}
                    </p>
                </div>

                <div class="bg-slate-50 border border-slate-100 rounded-xl p-4">
                    <p class="text-xs text-slate-400 mb-1">Lantai</p>
                    <p class="font-bold text-slate-700">
                        {{ $catalog->specifications->floors }}
                    </p>
                </div>
            </div>
        </div>
        @endif

        {{-- ================= FASILITAS ================= --}}
        {{-- Mobile: order 5 | Desktop: col-span-2 --}}
        @if($catalog->facilities->count())
        <div class="lg:col-span-2 order-5 bg-white border border-slate-200 rounded-2xl p-6">
            <h3 class="text-base font-bold text-slate-800 mb-4">Akses & Fasilitas</h3>

            <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                @foreach($catalog->facilities as $facility)
                    <div class="flex items-center gap-2 bg-slate-50 border border-slate-100 rounded-lg px-3 py-2">
                        <div class="w-1.5 h-1.5 bg-blue-500 rounded-full shrink-0"></div>
                        <span class="text-sm text-slate-600">{{ $facility->name }}</span>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

    </div>
</div>
@endsection