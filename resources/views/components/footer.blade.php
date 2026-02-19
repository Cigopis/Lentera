<footer class="bg-gradient-to-br from-blue-50 via-cyan-50 to-blue-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 lg:gap-12">
            
            <!-- Section 1: About Lelentera -->
            <div class="space-y-6">
                <!-- Logo -->
                <div class="flex items-center">
                    <img src="{{ asset('img/logo.png') }}" alt="Lelentera Logo" class="h-14 w-auto">
                </div>
                
                <!-- Description -->
                <p class="text-gray-700 text-sm leading-relaxed">
                    Lelang Terpadu BRI Kertajaya, Sebagai platform media promosi dan katalog digital lelang properti yang merupakan aset yang dijadikan jaminan kredit oleh nasabah pada bank BRI Kertajaya.
                </p>
                
                <!-- Powered By -->
                <div class="space-y-3">
                    <h3 class="font-bold text-gray-800 text-base">Powered By :</h3>
                    <div class="flex items-center gap-4">
                        <img src="{{ asset('img/bri-info-lelang.png') }}" alt="BRI Info Lelang" class="h-14 w-auto">
                        <img src="{{ asset('img/bri_logo.png') }}" alt="BRI" class="h-10 w-auto">
                    </div>
                </div>
            </div>

            <!-- Section 2: Kantor Cabang -->
            <div class="space-y-6">
                <!-- First Office -->
                <div class="space-y-3">
                    <h3 class="text-xl font-bold text-blue-900">Kantor Cabang</h3>
                    <p class="text-gray-700 text-sm leading-relaxed">
                        Gedung The Samator Land, Jl. Raya Kedung Baruk No.28 No.25, Sukolilo Baru, Bulak, Surabaya, East Java 60136
                    </p>
                </div>
                
                <!-- Second Office -->
                <div class="space-y-3 pt-4">
                    <h3 class="text-xl font-bold text-blue-900">Kantor Cabang</h3>
                    <a href="#" class="inline-block text-blue-700 hover:text-blue-900 text-sm font-medium underline transition-colors duration-200">
                        Privacy Policy
                    </a>
                </div>
            </div>

            <!-- Section 3: Hubungi Kami -->
            <div class="space-y-6">
                <h3 class="text-xl font-bold text-blue-900">Hubungi Kami</h3>
                
                <!-- WhatsApp Info -->
                <div class="flex items-start gap-4">
                    <!-- WhatsApp Icon -->
                    <div class="flex-shrink-0">
                        <div class="bg-white rounded-full p-3 shadow-lg">
                            <svg class="w-10 h-10 text-green-500" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                            </svg>
                        </div>
                    </div>
                    
                    <!-- WhatsApp Details -->
                    <div class="flex-1 space-y-1">
                        <p class="font-semibold text-gray-800 text-base">Whatsapp Only :</p>
                        <p class="text-sm text-gray-700">Jam Operasional : Senin - Jumat:</p>
                        <p class="text-sm text-gray-700 font-medium">7.30-16.30</p>
                        <p class="text-xs text-gray-600 italic">(kecuali Sabtu, Minggu dan Hari Libur)</p>
                    </div>
                </div>

                <!-- Address -->
                <div class="pt-2">
                    <p class="text-sm text-gray-700 leading-relaxed">
                        Gedung The Samator Land, Jl. Raya Kedung Baruk No.28 No.25, Sukolilo Baru, Bulak, Surabaya, East Java 60136
                    </p>
                </div>
            </div>
        </div>

        <!-- Bottom Section / Copyright -->
        <div class="mt-12 pt-8 border-t border-blue-200/50">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-sm text-gray-600">
                    &copy; {{ date('Y') }} Lelentera. All rights reserved.
                </p>
                <p class="text-sm text-gray-600">
                    Powered by BRI Kertajaya
                </p>
            </div>
        </div>
    </div>
</footer>