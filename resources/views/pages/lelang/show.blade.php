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
    </script>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 md:gap-8">

        {{-- ================= LEFT CONTENT ================= --}}
        <div class="lg:col-span-2 space-y-5">

            {{-- ================= GALLERY ================= --}}
            <div 
                x-data="{ 
                    selectedImage: '{{ $catalog->primaryImage?->image_path 
                        ? asset('storage/'.$catalog->primaryImage->image_path) 
                        : asset('img/default.jpg') }}',
                    showAll: false,
                    open: false
                }"
                class="bg-white border border-slate-200 rounded-2xl p-4"
            >

                {{-- MAIN IMAGE --}}
                <div class="relative overflow-hidden rounded-xl mb-4 cursor-pointer"
                     @click="open = true">
                    <img :src="selectedImage"
                         class="w-full h-[300px] md:h-[420px] object-cover transition duration-300 hover:scale-105">

                    <div class="absolute inset-0 bg-gradient-to-t from-black/10 to-transparent pointer-events-none"></div>
                </div>

                {{-- THUMBNAILS --}}
                <div class="grid grid-cols-4 gap-3">
                    @foreach($catalog->catalogImages as $index => $image)
                        <div 
                            x-show="showAll || {{ $index }} < 4"
                            class="overflow-hidden rounded-lg"
                        >
                            <img src="{{ asset('storage/'.$image->image_path) }}"
                                 @click="selectedImage = '{{ asset('storage/'.$image->image_path) }}'"
                                 class="h-20 md:h-24 w-full object-cover cursor-pointer 
                                        hover:scale-105 transition duration-300 hover:opacity-90">
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

                        <button @click="open = false"
                                class="absolute -top-10 right-0 text-white text-3xl hover:scale-110 transition">
                            ✕
                        </button>

                    </div>
                </div>


            </div>
            {{-- ================= END GALLERY ================= --}}

            {{-- DESKRIPSI --}}
            <div class="bg-white border border-slate-200 rounded-2xl p-6">
                <h3 class="text-base font-bold text-slate-800 mb-3">Deskripsi Aset</h3>
                <div class="text-slate-500 text-sm leading-relaxed">
                    {!! $catalog->description !!}
                </div>
            </div>

            {{-- SPESIFIKASI --}}
            @if($catalog->specifications)
            <div class="bg-white border border-slate-200 rounded-2xl p-6">
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

            {{-- FASILITAS --}}
            @if($catalog->facilities->count())
            <div class="bg-white border border-slate-200 rounded-2xl p-6">
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

        {{-- ================= RIGHT SIDEBAR ================= --}}
        <div class="space-y-5">

            <div class="bg-white border border-slate-200 rounded-2xl p-6 sticky top-24 shadow-md">

                {{-- STATUS BADGE --}}
                <div class="flex flex-wrap gap-2 mb-4">
                    <span class="px-3 py-1 text-xs rounded-full font-semibold bg-emerald-100 text-emerald-600">
                        {{ $catalog->status_label }}
                    </span>

                    @if($catalog->isExpiringSoon())
                        <span class="px-3 py-1 text-xs rounded-full font-semibold bg-blue-100 text-blue-600">
                            Open Bidding
                        </span>
                    @endif
                </div>

                {{-- LOKASI --}}
                <p class="text-sm text-slate-400 mb-2">
                    📍 {{ $catalog->city->name }}
                </p>

                {{-- JUDUL --}}
                <h1 class="text-lg md:text-xl font-semibold text-slate-800 mb-4 leading-snug">
                    {{ $catalog->title }}
                </h1>

                {{-- SHM / INFO TAMBAHAN --}}
                <div class="flex flex-wrap gap-2 mb-6">
                    <span class="px-3 py-1 text-xs rounded-lg border border-slate-200 bg-slate-50">
                        SHM
                    </span>
                    <span class="px-3 py-1 text-xs rounded-lg border border-slate-200 bg-slate-50">
                        Nomor SHM 1826327437236
                    </span>
                </div>

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

                {{-- SHARE & DOWNLOAD --}}
                <div class="flex gap-3 mb-4">

                    {{-- SHARE BUTTON --}}
                    <button
                        onclick="shareCatalog()"
                        class="flex-1 border border-slate-300 py-2 rounded-xl text-sm font-medium hover:bg-slate-50 transition">
                        🔗 Bagikan
                    </button>

                    {{-- DOWNLOAD BROSUR --}}
                    @if($catalog->official_auction_url)
                        <a href="{{ $catalog->official_auction_url }}"
                        target="_blank"
                        class="flex-1 border border-slate-300 py-2 rounded-xl text-sm font-medium text-center hover:bg-slate-50 transition">
                            ⬇ Unduh Brosur
                        </a>
                    @endif

                </div>
                
                <a href="https://wa.me/6281234567890?text=Saya%20tertarik%20dengan%20aset%20{{ urlencode($catalog->title) }}"
                target="_blank"
                class="block w-full bg-green-600 text-white text-center py-3 rounded-xl font-semibold hover:bg-green-700 transition">
                    💬 Hubungi Kami
                </a>

            </div>

        </div>


    </div>
</div>
@endsection
