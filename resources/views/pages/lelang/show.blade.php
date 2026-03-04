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
        Grid Layout - URUTAN YANG BENAR:
        Mobile: Gallery(1) → Sidebar(2) → Success(2.6) → Deskripsi(3) → Spesifikasi(4) → Fasilitas(5) → Upload(6)
        Desktop: kiri col-span-2 (Gallery, Deskripsi, Spesifikasi, Fasilitas, Upload) | kanan (Sidebar sticky)
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
                     x-show="images.length > 1">
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
        <div class="order-2 lg:row-span-6">
            <div class="bg-white border border-slate-200 rounded-2xl p-6 sticky top-24 shadow-md">

                {{-- STATUS BADGE --}}
                <div class="flex flex-wrap gap-2 mb-4">
                    <span class="px-3 py-1 text-xs rounded-full font-semibold bg-emerald-100 text-emerald-600">
                        {{ $catalog->status_label }}
                    </span>

                    @php $daysLeft = $catalog->getDaysUntilAuction(); @endphp

                    @if($daysLeft !== null && $daysLeft >= 0)
                        <span class="px-3 py-1 text-xs rounded-full font-semibold
                            {{ $daysLeft == 0 ? 'bg-red-100 text-red-600' : 
                            ($daysLeft == 1 ? 'bg-orange-100 text-orange-600' : 'bg-blue-100 text-blue-600') }}">
                            {{ $catalog->getDeadlineStatus() }}
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
                            {{ $catalog->auction_date->copy()->subDay()->format('d F Y') }}
                        </p>
                    </div>

                    <div>
                        <p class="text-slate-400">Batas Akhir Penawaran</p>
                        <p class="font-medium">
                            {{ $catalog->auction_date->format('d F Y') }} 13.00 WIB
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

        {{-- SUCCESS MESSAGE --}}
        @if(session('success'))
        <div class="lg:col-span-3 order-[2.6]">
            <div class="bg-green-50 border-2 border-green-200 rounded-xl p-4 flex items-start gap-3" x-data="{ show: true }" x-show="show" x-transition>
                <svg class="w-6 h-6 text-green-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div class="flex-1">
                    <p class="font-semibold text-green-800">Berhasil!</p>
                    <p class="text-sm text-green-700">{{ session('success') }}</p>
                </div>
                <button @click="show = false" class="text-green-600 hover:text-green-800">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
        @endif

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
        @if($catalog->land_area || $catalog->building_area || $catalog->bedrooms || $catalog->bathrooms || $catalog->floors)
        <div class="lg:col-span-2 order-4 bg-white border border-slate-200 rounded-2xl p-6">
            <h3 class="text-base font-bold text-slate-800 mb-4">Spesifikasi Aset</h3>

            <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
                @if($catalog->land_area)
                <div class="bg-blue-50 border border-blue-100 rounded-xl p-4">
                    <p class="text-xs text-slate-400 mb-1">Luas Tanah (LT)</p>
                    <p class="font-bold text-blue-600">
                        {{ number_format($catalog->land_area, 0, ',', '.') }} m²
                    </p>
                </div>
                @endif

                @if($catalog->building_area)
                <div class="bg-blue-50 border border-blue-100 rounded-xl p-4">
                    <p class="text-xs text-slate-400 mb-1">Luas Bangunan (LB)</p>
                    <p class="font-bold text-blue-600">
                        {{ number_format($catalog->building_area, 0, ',', '.') }} m²
                    </p>
                </div>
                @endif

                @if($catalog->bedrooms)
                <div class="bg-slate-50 border border-slate-100 rounded-xl p-4">
                    <p class="text-xs text-slate-400 mb-1">Kamar Tidur</p>
                    <p class="font-bold text-slate-700">
                        {{ $catalog->bedrooms }}
                    </p>
                </div>
                @endif

                @if($catalog->bathrooms)
                <div class="bg-slate-50 border border-slate-100 rounded-xl p-4">
                    <p class="text-xs text-slate-400 mb-1">Kamar Mandi</p>
                    <p class="font-bold text-slate-700">
                        {{ $catalog->bathrooms }}
                    </p>
                </div>
                @endif

                @if($catalog->floors)
                <div class="bg-slate-50 border border-slate-100 rounded-xl p-4">
                    <p class="text-xs text-slate-400 mb-1">Jumlah Lantai</p>
                    <p class="font-bold text-slate-700">
                        {{ $catalog->floors }}
                    </p>
                </div>
                @endif
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

        {{-- ================= UPLOAD BUKTI PEMBAYARAN ================= --}}
        {{-- Mobile: order 6 | Desktop: col-span-2 --}}
        <div class="lg:col-span-2 order-6 bg-gradient-to-br from-blue-50 to-indigo-50 border-2 border-blue-200 rounded-2xl p-6 md:p-8" 
             x-data="{ 
                 showUpload: false, 
                 paymentType: 'ujl',
                 showInfo: true 
             }">
            
            {{-- INFO HEADER --}}
            <div class="flex items-start gap-4 mb-6">
                <div class="flex-shrink-0 w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <h3 class="text-xl font-bold text-blue-900 mb-2">
                        Informasi Penting untuk Peserta Lelang
                    </h3>
                    <p class="text-sm text-blue-700 leading-relaxed">
                        Sebelum mengikuti lelang, Anda <strong>wajib</strong> mengunggah bukti pembayaran Uang Jaminan Lelang (UJL). 
                        Setelah memenangkan lelang, Anda juga <strong>wajib</strong> mengunggah bukti pelunasan.
                    </p>
                </div>
            </div>

            {{-- PANDUAN SINGKAT --}}
            <div x-show="showInfo" 
                 x-transition
                 class="bg-white rounded-xl p-5 mb-6 border border-blue-100">
                <div class="flex items-start justify-between mb-4">
                    <h4 class="font-bold text-gray-800 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Panduan Upload Bukti Pembayaran
                    </h4>
                    <button @click="showInfo = false" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <div class="grid md:grid-cols-2 gap-4 text-sm text-gray-600">
                    <div class="space-y-3">
                        <div class="flex gap-3">
                            <div class="flex-shrink-0 w-6 h-6 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-xs font-bold">1</div>
                            <div>
                                <p class="font-semibold text-gray-800">Upload Bukti UJL</p>
                                <p class="text-xs">Unggah bukti transfer Uang Jaminan Lelang sebelum batas waktu yang ditentukan</p>
                            </div>
                        </div>
                        <div class="flex gap-3">
                            <div class="flex-shrink-0 w-6 h-6 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-xs font-bold">2</div>
                            <div>
                                <p class="font-semibold text-gray-800">Tunggu Verifikasi</p>
                                <p class="text-xs">Tim kami akan memverifikasi bukti pembayaran Anda (maks. 1x24 jam)</p>
                            </div>
                        </div>
                    </div>
                    <div class="space-y-3">
                        <div class="flex gap-3">
                            <div class="flex-shrink-0 w-6 h-6 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-xs font-bold">3</div>
                            <div>
                                <p class="font-semibold text-gray-800">Ikuti Lelang</p>
                                <p class="text-xs">Setelah terverifikasi, Anda dapat mengikuti lelang pada tanggal yang ditentukan</p>
                            </div>
                        </div>
                        <div class="flex gap-3">
                            <div class="flex-shrink-0 w-6 h-6 bg-green-100 text-green-600 rounded-full flex items-center justify-center text-xs font-bold">4</div>
                            <div>
                                <p class="font-semibold text-gray-800">Upload Bukti Pelunasan</p>
                                <p class="text-xs">Jika menang, unggah bukti pelunasan sesuai jangka waktu yang ditentukan</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4 pt-4 border-t border-gray-200">
                    <p class="text-xs text-gray-500 flex items-start gap-2">
                        <svg class="w-4 h-4 text-amber-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        <span><strong>Penting:</strong> Pastikan bukti transfer jelas dan terbaca. Format yang diterima: JPG, PNG, PDF (maks. 5MB)</span>
                    </p>
                </div>
            </div>

            {{-- UPLOAD BUTTON --}}
            <div class="flex flex-col sm:flex-row gap-3">
                <button @click="showUpload = true; paymentType = 'ujl'" 
                        class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-4 px-6 rounded-xl transition-all transform hover:scale-105 shadow-lg hover:shadow-xl flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                    </svg>
                    Upload Bukti UJL
                </button>
                
                <button @click="showUpload = true; paymentType = 'pelunasan'" 
                        class="flex-1 bg-green-600 hover:bg-green-700 text-white font-semibold py-4 px-6 rounded-xl transition-all transform hover:scale-105 shadow-lg hover:shadow-xl flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Upload Bukti Pelunasan
                </button>
            </div>

            {{-- UPLOAD MODAL --}}
            <div x-show="showUpload"
                 x-transition.opacity
                 class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm p-4"
                 @click.self="showUpload = false"
                 style="display: none;">
                
                <div class="bg-white rounded-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto shadow-2xl">
                    {{-- MODAL HEADER --}}
                    <div class="sticky top-0 bg-gradient-to-r from-blue-600 to-indigo-600 text-white p-6 rounded-t-2xl">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-xl font-bold mb-1" x-text="paymentType === 'ujl' ? 'Upload Bukti Uang Jaminan Lelang' : 'Upload Bukti Pelunasan'"></h3>
                                <p class="text-sm text-blue-100">{{ $catalog->title }}</p>
                            </div>
                            <button @click="showUpload = false" class="text-white hover:bg-white/20 rounded-full p-2 transition">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- MODAL BODY --}}
                    <form action="{{ route('payment-proof.store', $catalog) }}" 
                          method="POST" 
                          enctype="multipart/form-data"
                          class="p-6 space-y-5">
                        @csrf

                        <input type="hidden" name="payment_type" :value="paymentType">

                        {{-- INFORMASI NILAI --}}
                        <div class="bg-gray-50 rounded-xl p-4 border border-gray-200">
                            <div class="grid md:grid-cols-2 gap-4 text-sm">
                                <div>
                                    <p class="text-gray-500 mb-1">Nilai UJL yang Harus Dibayar</p>
                                    <p class="text-lg font-bold text-blue-600">{{ $catalog->formatted_deposit_amount }}</p>
                                </div>
                                <div x-show="paymentType === 'pelunasan'">
                                    <p class="text-gray-500 mb-1">Nilai Pelunasan</p>
                                    <p class="text-lg font-bold text-green-600">{{ $catalog->formatted_reserve_price }}</p>
                                </div>
                            </div>
                        </div>

                        {{-- DATA PESERTA --}}
                        <div class="space-y-4">
                            <h4 class="font-bold text-gray-800 flex items-center gap-2">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                Data Peserta Lelang
                            </h4>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Nama Lengkap <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       name="user_name" 
                                       required
                                       value="{{ old('user_name') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                       placeholder="Masukkan nama lengkap sesuai KTP">
                                @error('user_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Email <span class="text-red-500">*</span>
                                    </label>
                                    <input type="email" 
                                           name="user_email" 
                                           required
                                           value="{{ old('user_email') }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                           placeholder="email@example.com">
                                    @error('user_email')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        No. Telepon <span class="text-red-500">*</span>
                                    </label>
                                    <input type="tel" 
                                           name="user_phone" 
                                           required
                                           value="{{ old('user_phone') }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                           placeholder="08xxxxxxxxxx">
                                    @error('user_phone')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- BUKTI PEMBAYARAN --}}
                        <div class="space-y-4">
                            <h4 class="font-bold text-gray-800 flex items-center gap-2">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                Bukti Pembayaran
                            </h4>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Nominal Pembayaran <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 font-medium">Rp</span>
                                    <input type="number" 
                                           name="amount" 
                                           required
                                           min="0"
                                           value="{{ old('amount') }}"
                                           class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                           placeholder="0">
                                </div>
                                @error('amount')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Upload Bukti Transfer <span class="text-red-500">*</span>
                                </label>
                                <div class="mt-2 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-xl hover:border-blue-400 transition cursor-pointer"
                                     onclick="document.getElementById('proof_image').click()">
                                    <div class="space-y-2 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        <div class="text-sm text-gray-600">
                                            <label class="relative cursor-pointer rounded-md font-medium text-blue-600 hover:text-blue-500">
                                                <span>Klik untuk upload</span>
                                                <input id="proof_image" name="proof_image" type="file" class="sr-only" accept="image/*,.pdf" required>
                                            </label>
                                            <p class="pl-1">atau drag and drop</p>
                                        </div>
                                        <p class="text-xs text-gray-500">PNG, JPG, PDF hingga 5MB</p>
                                    </div>
                                </div>
                                @error('proof_image')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Catatan (Opsional)
                                </label>
                                <textarea name="notes" 
                                          rows="3"
                                          class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                          placeholder="Tambahkan catatan jika diperlukan...">{{ old('notes') }}</textarea>
                            </div>
                        </div>

                        {{-- SUBMIT BUTTONS --}}
                        <div class="flex gap-3 pt-4">
                            <button type="button" 
                                    @click="showUpload = false"
                                    class="flex-1 px-6 py-3 border-2 border-gray-300 rounded-xl font-semibold text-gray-700 hover:bg-gray-50 transition">
                                Batal
                            </button>
                            <button type="submit"
                                    class="flex-1 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-semibold transition shadow-lg hover:shadow-xl">
                                Upload Bukti Pembayaran
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- ================= END UPLOAD SECTION ================= --}}

    </div>
</div>
@endsection