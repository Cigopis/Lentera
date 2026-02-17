@props(['banners'])

@if($banners->count())
<div 
    x-data="{
        active: 0,
        total: {{ $banners->count() }},
        init() {
            setInterval(() => this.next(), 5000)
        },
        next() {
            this.active = (this.active + 1) % this.total
        },
        go(index) {
            this.active = index
        }
    }"
    class="relative w-full"
>

    {{-- SLIDES TRACK --}}
    <div 
        class="flex transition-transform duration-500 ease-in-out"
        :style="'transform: translateX(-' + (active * 100) + '%)'"
    >

        @foreach($banners as $banner)

            <div class="w-full flex-shrink-0">

                @if($banner->aspect_ratio === 'custom')

                    <img 
                        src="{{ asset('storage/'.$banner->image_path) }}"
                        class="w-full h-auto"
                        alt="{{ $banner->title ?? 'Banner' }}"
                    >

                @else

                    <div class="w-full aspect-[21/9] flex items-center justify-center">
                        <img 
                            src="{{ asset('storage/'.$banner->image_path) }}"
                            class="w-full h-full object-contain"
                            alt="{{ $banner->title ?? 'Banner' }}"
                        >
                    </div>

                @endif

            </div>

        @endforeach

    </div>

    {{-- DOT NAVIGATION --}}
    <div class="absolute bottom-10 left-1/2 -translate-x-1/2 flex">
        @foreach($banners as $index => $banner)
            <button 
                @click="go({{ $index }})"
                :class="active === {{ $index }} 
                    ? 'w-4 h-4 bg-blue-600 scale-50' 
                    : 'w-4 h-4 bg-gray-300 scale-50'"
                class="rounded-full transition-all duration-300"
            ></button>
        @endforeach
    </div>

</div>
@endif
