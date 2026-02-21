@extends('layouts.app')

@section('content')

<section class="max-w-7xl mx-auto px-6 md:px-12 py-20">

    {{-- HEADER --}}
    <div class="mb-16 text-center">

        <h1 class="text-3xl md:text-4xl font-semibold mb-1 pt-4">
            Hasil Pencarian
        </h1>

        <p class="text-slate-500 mb-4">
            @if(request()->filled('search'))
                <p class="text-sm text-gray-600 mb-4">
                    Menampilkan hasil untuk: 
                    <span class="font-semibold">"{{ request('search') }}"</span>
                </p>
            @endif
        </p>

        {{-- SEARCH BAR --}}
        <form method="GET"
              action="{{ route('lelang.index') }}"
              class="relative max-w-2xl mx-auto">

            <input type="text"
                   name="search"
                   value="{{ request('search') ?? '' }}"
                   placeholder="Cari aset, lokasi, atau kategori..."
                   class="w-full rounded-2xl
                          bg-white
                          border border-slate-200
                          px-6 py-4 pr-14
                          text-sm md:text-base
                          shadow-md
                          focus:outline-none
                          focus:ring-2 focus:ring-blue-500/30
                          transition">

            <button type="submit"
                    class="absolute right-4 top-1/2 -translate-y-1/2
                           bg-blue-600 hover:bg-blue-700
                           text-white p-2 rounded-xl
                           shadow-md transition">

                <x-heroicon-o-magnifying-glass class="w-5 h-5"/>
            </button>
        </form>
    </div>


    {{-- RESULT INFO --}}
    <div class="mb-10 text-center md:text-left">
        <p class="text-sm text-slate-500">
            Ditemukan {{ $catalogs->total() }} katalog
        </p>
    </div>


    {{-- GRID KATALOG MARKETPLACE STYLE --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8 items-stretch">

        @forelse($catalogs as $catalog)

            <div class="h-full">
                <x-catalog-card :catalog="$catalog" layout="vertical" />
            </div>

        @empty

            {{-- EMPTY STATE --}}
            <div class="col-span-full text-center py-24">

                <div class="inline-flex items-center justify-center
                            w-20 h-20 rounded-full
                            bg-blue-50 mb-6">

                    <x-heroicon-o-magnifying-glass
                        class="w-10 h-10 text-blue-500"/>
                </div>

                <h3 class="text-xl font-semibold mb-3">
                    Tidak ada hasil ditemukan
                </h3>

                <p class="text-slate-500 mb-6">
                    Coba gunakan kata kunci lain atau periksa kembali ejaan pencarian Anda.
                </p>

                <a href="{{ route('katalog.index') }}"
                   class="inline-block px-6 py-3
                          bg-blue-600 text-white
                          rounded-xl shadow-md
                          hover:bg-blue-700 transition">
                    Kembali ke Katalog
                </a>

            </div>

        @endforelse

    </div>


    {{-- PAGINATION --}}
    @if($catalogs->hasPages())
        <div class="mt-16 flex justify-center">
            {{ $catalogs->appends(request()->query())->links() }}
        </div>
    @endif

</section>

@endsection
