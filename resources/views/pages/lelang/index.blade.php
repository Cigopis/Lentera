<section class="max-w-7xl mx-auto px-6 py-10">

    @forelse($catalogs as $catalog)
        <x-catalog-card :catalog="$catalog" />
    @empty
        <p class="text-center text-gray-500">
            Tidak ada katalog ditemukan.
        </p>
    @endforelse

</section>
