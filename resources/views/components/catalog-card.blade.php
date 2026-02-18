@props(['catalog'])

<div class="bg-gray-100 rounded-2xl p-4 flex gap-4">

    {{-- IMAGE --}}
    <div class="w-5/12">
        <img 
            src="{{ $catalog->primaryImage?->image_path 
                ? asset('storage/'.$catalog->primaryImage->image_path) 
                : asset('img/default.jpg') }}"
            class="rounded-xl w-full h-48 object-cover"
        >
    </div>

    {{-- CONTENT --}}
    <div class="w-7/12 flex flex-col justify-between">

        <div>
            {{-- Status --}}
            <div class="flex justify-between items-center mb-2">
                <span class="text-orange-600 font-semibold text-sm">
                    Lentera
                </span>

                <span class="px-3 py-1 rounded-full text-xs font-semibold
                    {{ $catalog->status == 'active' ? 'bg-green-100 text-green-700' : 'bg-gray-200 text-gray-600' }}">
                    {{ $catalog->status_label }}
                </span>
            </div>

            {{-- Location --}}
            <p class="flex items-center gap-1 text-blue-600 text-xs mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-3 h-3">
                    <path fill-rule="evenodd" d="m11.54 22.351.07.04.028.016a.76.76 0 0 0 .723 0l.028-.015.071-.041a16.975 16.975 0 0 0 1.144-.742 19.58 19.58 0 0 0 2.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 0 0-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 0 0 2.682 2.282 16.975 16.975 0 0 0 1.145.742ZM12 13.5a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" clip-rule="evenodd" />
                </svg>
                {{ $catalog->city->name }}
            </p>

            {{-- Title --}}
            <h3 class="text-base font-bold mb-2 line-clamp-2">
                {{ $catalog->title }}
            </h3>

            {{-- Description --}}
            <p class="text-gray-600 text-xs mb-3 line-clamp-2">
                {{ Str::limit(strip_tags($catalog->description), 80) }}
            </p>

            {{-- Price --}}
            <div class="flex justify-between mb-3 text-xs">
                <div>
                    <p class="text-gray-500">Nilai limit</p>
                    <p class="text-blue-700 font-bold">
                        {{ $catalog->formatted_reserve_price }}
                    </p>
                </div>

                <div>
                    <p class="text-gray-500">Uang Jaminan</p>
                    <p class="text-blue-700 font-bold">
                        {{ $catalog->formatted_deposit_amount }}
                    </p>
                </div>
            </div>

            <p class="text-gray-500 text-xs">
                {{ $catalog->auction_date->format('d M Y') }}
            </p>
        </div>

        <a href="#" class="text-blue-600 text-xs font-semibold mt-2 text-right px-4">
            Lihat →
        </a>

    </div>

</div>
