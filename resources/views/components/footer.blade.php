<footer class="bg-gradient-to-br from-blue-50 via-cyan-50 to-blue-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">

        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">

            <!-- ABOUT -->
            <div class="space-y-5">
                <img src="{{ asset('img/logo.png') }}" alt="Lelentera Logo" class="h-14">

                <p class="text-gray-700 text-sm leading-relaxed">
                    Lelang Terpadu BRI Kertajaya sebagai platform media promosi dan katalog
                    digital lelang properti yang merupakan aset jaminan kredit nasabah
                    Bank BRI Kertajaya.
                </p>

                <div>
                    <p class="font-semibold text-gray-800 text-sm mb-2">Powered By :</p>
                    <div class="flex items-center gap-4">
                        <img src="{{ asset('img/bri-info-lelang.png') }}" alt="BRI Info Lelang" class="h-9">
                        <img src="{{ asset('img/bri_logo.png') }}" alt="BRI" class="h-9">
                    </div>
                </div>
            </div>

            <!-- KANTOR CABANG -->
            <div class="space-y-5">
                <h3 class="text-lg font-bold text-blue-900">Kantor Cabang</h3>

                <p class="text-gray-700 text-sm leading-relaxed">
                    Gedung The Samator Land,<br>
                    Jl. Raya Kedung Baruk No.28 No.25,<br>
                    Sukolilo Baru, Bulak,<br>
                    Surabaya, East Java 60136
                </p>

                <a href="#" class="text-sm font-medium text-blue-700 hover:underline">
                    Privacy Policy
                </a>
            </div>

            <!-- HUBUNGI KAMI -->
            <div class="space-y-5">
                <h3 class="text-lg font-bold text-blue-900">Hubungi Kami</h3>

                <div class="flex gap-4 items-start">
                    <div class="bg-white p-3 rounded-full shadow flex-shrink-0">
                        <!-- WhatsApp Icon - SVG Lengkap -->
                        <svg class="w-7 h-7 text-green-500" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                        </svg>
                    </div>

                    <div class="text-sm text-gray-700 flex-1">
                        <p class="font-semibold text-gray-800">Whatsapp Only</p>
                        <p>Senin – Jumat</p>
                        <p class="font-medium">07.30 – 16.30</p>
                        <p class="text-xs italic text-gray-600">
                            (kecuali Sabtu, Minggu & Hari Libur)
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- COPYRIGHT -->
        <div class="mt-10 pt-6 border-t border-blue-200 flex flex-col md:flex-row justify-between items-center gap-2 text-sm text-gray-600">
            <p>&copy; {{ date('Y') }} Lelentera. All rights reserved.</p>
            <p>Powered by BRI Kertajaya</p>
        </div>

    </div>
</footer>