@extends('layouts.app')

@section('content')

    {{-- Banner Slider --}}
    <x-banner-slider :banners="$banners" />

    <section class="max-w-7xl mx-auto px-6">

        <div class="flex flex-col lg:flex-row gap-8 items-start">

            {{-- LEFT SIDE --}}
            <div class="flex-1">
                <h2 class="text-3xl font-bold text-blue-700 mb-6">
                    Kategori Lot Lelang
                </h2>

                <div class="flex gap-4 flex-wrap">
                    <button class="px-5 py-2 border rounded-lg hover:bg-blue-600 hover:text-white">Semua</button>
                    <button class="px-5 py-2 border rounded-lg hover:bg-blue-600 hover:text-white">Rumah</button>
                    <button class="px-5 py-2 border rounded-lg hover:bg-blue-600 hover:text-white">Gudang</button>
                    <button class="px-5 py-2 border rounded-lg hover:bg-blue-600 hover:text-white">Mobil</button>
                    <button class="px-5 py-2 border rounded-lg hover:bg-blue-600 hover:text-white">Tanah</button>
                </div>
            </div>

            {{-- RIGHT SIDE CARD --}}
            <div class="w-full lg:w-[420px] bg-blue-100 rounded-xl p-5 border border-blue-700">

                {{-- Logo --}}
                <div class="mb-4">
                    <img 
                        src="{{ asset('img/bri-info-lelang.png') }}" 
                        alt="BRI Info Lelang"
                        class="h-16"
                    >
                </div>

                {{-- Menu Grid --}}
                <div class="grid grid-cols-3 gap-3">

                    {{-- Jadwal --}}
                    <div class="bg-blue-800 rounded-lg p-4 text-white text-center hover:scale-105 transition duration-200">
                        <div class="flex justify-center mb-2">
                            {{-- Heroicon Calendar --}}
                            <svg xmlns="http://www.w3.org/2000/svg" 
                                class="w-6 h-6 text-yellow-300" 
                                fill="none" 
                                viewBox="0 0 24 24" 
                                stroke="currentColor" 
                                stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" 
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div class="text-sm font-semibold">Jadwal</div>
                    </div>

                    {{-- Hot Deals --}}
                    <div class="bg-blue-800 rounded-lg p-4 text-white text-center hover:scale-105 transition duration-200">
                        <div class="flex justify-center mb-2">
                            {{-- Heroicon Fire --}}
                            <svg xmlns="http://www.w3.org/2000/svg" 
                                class="w-6 h-6 text-yellow-300" 
                                fill="none" 
                                viewBox="0 0 24 24" 
                                stroke="currentColor" 
                                stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" 
                                    d="M12 3c.132 2.378-1.207 4.154-2.49 5.438C8.233 9.715 7 11.5 7 13.5A5 5 0 0017 13c0-2.5-1.5-4-3-5.5S12 4 12 3z" />
                            </svg>
                        </div>
                        <div class="text-sm font-semibold">Hot Deals</div>
                    </div>

                    {{-- Populer --}}
                    <div class="bg-blue-800 rounded-lg p-4 text-white text-center hover:scale-105 transition duration-200">
                        <div class="flex justify-center mb-2">
                            {{-- Heroicon Star --}}
                            <svg xmlns="http://www.w3.org/2000/svg" 
                                class="w-6 h-6 text-yellow-300" 
                                fill="none" 
                                viewBox="0 0 24 24" 
                                stroke="currentColor" 
                                stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" 
                                    d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l2.036 6.26h6.587c.969 0 1.371 1.24.588 1.81l-5.33 3.872 2.036 6.26c.3.921-.755 1.688-1.54 1.118L12 17.77l-5.328 3.877c-.785.57-1.84-.197-1.54-1.118l2.036-6.26-5.33-3.872c-.783-.57-.38-1.81.588-1.81h6.587l2.036-6.26z" />
                            </svg>
                        </div>
                        <div class="text-sm font-semibold">Populer</div>
                    </div>

                </div>

            </div>


        </div>

    </section>


@endsection
