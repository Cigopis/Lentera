@extends('layouts.app')

@section('content')

<section class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-50 pt-32 pb-24">

    <div class="max-w-7xl mx-auto px-6">

        {{-- HEADER --}}
        <div class="text-center mb-14">
            <h1 class="text-4xl md:text-5xl font-bold text-slate-800 mb-4">
                E-Katalog Lelang
            </h1>
            <p class="text-slate-500 max-w-2xl mx-auto">
                Temukan berbagai aset lelang terbaik sesuai kategori pilihan Anda.
            </p>
        </div>

        {{-- FILTER KATEGORI --}}
        <div class="flex flex-wrap justify-center gap-3 md:gap-4 mb-12">

            <a href="{{ route('katalog.index') }}"
               class="px-5 md:px-6 py-2 rounded-full text-sm font-medium transition
               {{ request('kategori')
                    ? 'bg-white border border-slate-200 text-slate-600 hover:bg-blue-600 hover:text-white'
                    : 'bg-blue-600 text-white shadow-md shadow-blue-400/30' }}">
                Semua
            </a>

            @foreach($categories as $category)
                <a href="{{ route('katalog.index', ['kategori' => $category->slug]) }}"
                   class="px-5 md:px-6 py-2 rounded-full text-sm font-medium transition
                   {{ request('kategori') == $category->slug
                        ? 'bg-blue-600 text-white shadow-md shadow-blue-400/30'
                        : 'bg-white border border-slate-200 text-slate-600 hover:bg-blue-600 hover:text-white' }}">
                    {{ $category->name }}
                </a>
            @endforeach

        </div>

        {{-- INFO KATEGORI --}}
        <div class="text-center mb-10">
            <p class="text-slate-500 text-sm md:text-base">
                Menampilkan:
                <span class="font-semibold text-blue-600">
                    {{ request('kategori') ?? 'Semua Kategori' }}
                </span>
            </p>
        </div>

        {{-- GRID KATALOG MARKETPLACE STYLE --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8 items-stretch">

            @forelse($catalogs as $catalog)
                {{-- Vertical layout khusus halaman ini --}}
                <x-catalog-card :catalog="$catalog" layout="vertical" />
            @empty
                <div class="col-span-full text-center py-20 text-slate-400">
                    Tidak ada katalog tersedia saat ini.
                </div>
            @endforelse

        </div>

        {{-- PAGINATION --}}
        <div class="mt-14">
            {{ $catalogs->onEachSide(1)->links() }}
        </div>

    </div>

</section>

@endsection
