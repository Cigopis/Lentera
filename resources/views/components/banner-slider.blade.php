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
    class="{{ $variant === 'hero' 
        ? 'absolute inset-0 w-full h-full overflow-hidden z-0' 
        : 'relative w-full overflow-hidden' 
    }}"
>

    {{-- Wrapper: flex row, geser pakai translateX --}}
    <div 
        class="{{ $variant === 'hero' ? 'absolute inset-0 flex' : 'flex w-full' }}"
        :style="'transform: translateX(-' + (active * 100) + '%); transition: transform 0.7s cubic-bezier(0.77, 0, 0.18, 1);'"
    >
        @foreach($banners as $index => $banner)
            <div class="{{ $variant === 'hero'
                ? 'absolute inset-0 w-full h-full flex-shrink-0'
                : 'w-full flex-shrink-0'
            }}"
            style="width: 100%;"
            >
                <img 
                    src="{{ asset('storage/'.$banner->image_path) }}"
                    class="w-full {{ $variant === 'hero'
                        ? 'h-full object-cover'
                        : 'h-auto object-contain'
                    }}"
                    alt="{{ $banner->title ?? 'Banner' }}"
                >
            </div>
        @endforeach
    </div>

    {{-- Overlay hanya untuk hero --}}
    @if($variant === 'hero')
        <div class="absolute inset-0 bg-gradient-to-b from-white/70 via-white/60 to-white/80"></div>
    @endif

    {{-- Dots --}}
    @if($banners->count() > 1)
    <div class="flex gap-3 z-30
        {{ $variant === 'hero' 
            ? 'absolute bottom-10 left-1/2 -translate-x-1/2 justify-center' 
            : 'justify-center mt-4'
        }}"
    >
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
    @endif

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