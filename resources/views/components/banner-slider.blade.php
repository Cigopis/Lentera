@props([
    'banners',
    'variant' => 'hero' // hero | promo
])

@if($banners->count())
<div 
    x-data="bannerSlider()"
    x-init="init()"
    @mouseenter="pause()"
    @mouseleave="play()"

    class="
        {{ $variant === 'hero' 
            ? 'absolute inset-0 w-full h-full overflow-hidden z-0' 
            : 'relative w-full' 
        }}
    "
>

    @foreach($banners as $index => $banner)

        <div 
            x-show="active === {{ $index }}"
            x-transition:enter="transition duration-1000 ease-out"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition duration-1000 ease-in"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"

            class="
                {{ $variant === 'hero'
                    ? 'absolute inset-0 w-full h-full'
                    : 'relative w-full'
                }}
            "
        >

            <img 
                src="{{ asset('storage/'.$banner->image_path) }}"
                class="
                    w-full
                    {{ $variant === 'hero'
                        ? 'h-full object-cover transition-transform duration-[8000ms] ease-linear'
                        : 'h-auto object-contain'
                    }}
                "
                :class="{
                    'scale-100': active === {{ $index }} && '{{ $variant }}' === 'hero',
                    'scale-110': active !== {{ $index }} && '{{ $variant }}' === 'hero'
                }"
                alt="{{ $banner->title ?? 'Banner' }}"
            >

        </div>

    @endforeach


    {{-- Overlay hanya untuk hero --}}
    @if($variant === 'hero')
        <div class="absolute inset-0 bg-gradient-to-b from-white/70 via-white/60 to-white/80"></div>
    @endif


    {{-- Dots --}}
    <div class="
        {{ $variant === 'hero' 
            ? 'absolute bottom-10 left-1/2 -translate-x-1/2' 
            : 'flex justify-center mt-4'
        }}
        gap-3 z-30
    ">
        @foreach($banners as $index => $banner)
            <button 
                @click="go({{ $index }})"
                class="h-2 rounded-full transition-all duration-500"
                :class="active === {{ $index }} 
                    ? 'w-10 bg-blue-500 shadow-lg shadow-blue-500/40' 
                    : 'w-4 bg-gray-400 hover:bg-gray-600'"
            ></button>
        @endforeach
    </div>


</div>

<script>
function bannerSlider() {
    return {
        active: 0,
        total: {{ $banners->count() }},
        interval: null,

        init() {
            this.play()
        },

        play() {
            this.interval = setInterval(() => {
                this.next()
            }, 7000)
        },

        pause() {
            clearInterval(this.interval)
        },

        next() {
            this.active = (this.active + 1) % this.total
        },

        prev() {
            this.active = (this.active - 1 + this.total) % this.total
        },

        go(index) {
            this.active = index
        }
    }
}
</script>
@endif
