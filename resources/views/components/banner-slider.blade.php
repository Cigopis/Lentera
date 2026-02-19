@props(['banners'])

@if($banners->count())
<div 
    x-data="bannerSlider()"
    x-init="init()"
    @mouseenter="pause()"
    @mouseleave="play()"
    class="absolute inset-0 w-full h-full overflow-hidden z-0"
>

    {{-- SLIDES --}}
    @foreach($banners as $index => $banner)

        <div 
            x-show="active === {{ $index }}"
            x-transition:enter="transition duration-1000 ease-out"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition duration-1000 ease-in"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="absolute inset-0 w-full h-full"
        >

            {{-- IMAGE --}}
            <img 
                src="{{ asset('storage/'.$banner->image_path) }}"
                class="w-full h-full object-cover transition-transform duration-[8000ms] ease-linear"
                :class="active === {{ $index }} ? 'scale-100' : 'scale-110'"
                alt="{{ $banner->title ?? 'Banner' }}"
            >

        </div>

    @endforeach


    {{-- DARK GRADIENT OVERLAY --}}
    <div class="absolute inset-0 bg-gradient-to-b from-white/70 via-white/60 to-white/80"></div>




    {{-- MODERN PROGRESS DOTS --}}
    <div class="absolute bottom-10 left-1/2 -translate-x-1/2 flex gap-3 z-30">
        @foreach($banners as $index => $banner)
            <button 
                @click="go({{ $index }})"
                class="h-2 rounded-full transition-all duration-500"
                :class="active === {{ $index }} 
                    ? 'w-10 bg-blue-500 shadow-lg shadow-blue-500/40' 
                    : 'w-4 bg-white/40 hover:bg-white/70'"
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
