<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AuctionCatalogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminId = DB::table('users')->where('role', 'admin')->first()->id;
        $categoryBangunan = DB::table('categories')->where('slug', 'bangunan')->first()->id;
        $categoryTanah = DB::table('categories')->where('slug', 'tanah')->first()->id;
        $categoryKendaraan = DB::table('categories')->where('slug', 'kendaraan')->first()->id;
        
        $subCategoryRumah = DB::table('sub_categories')->where('slug', 'rumah')->first()->id;
        $subCategoryRuko = DB::table('sub_categories')->where('slug', 'ruko')->first()->id;
        $subCategoryTanahKosong = DB::table('sub_categories')->where('slug', 'tanah-kosong')->first()->id;
        $subCategoryMobil = DB::table('sub_categories')->where('slug', 'mobil')->first()->id;
        
        $citySurabaya = DB::table('cities')->where('name', 'Surabaya')->first()->id;
        $citySidoarjo = DB::table('cities')->where('name', 'Sidoarjo')->first()->id;
        $cityMalang = DB::table('cities')->where('name', 'Malang')->first()->id;

        $catalogs = [
            // Rumah 1
            [
                'catalog_code' => 'LNT-2026-001',
                'shm_number' => 'SHM No. 1234/Surabaya',
                'category_id' => $categoryBangunan,
                'sub_category_id' => $subCategoryRumah,
                'title' => 'Rumah 2 Lantai Siap Huni di Surabaya Timur',
                'slug' => 'rumah-2-lantai-siap-huni-surabaya-timur',
                'description' => 'Rumah 2 lantai dalam kondisi baik dan siap huni. Lokasi strategis dekat dengan fasilitas umum seperti sekolah, rumah sakit, dan pusat perbelanjaan. Akses jalan lebar dan mudah dijangkau.',
                'reserve_price' => 850000000,
                'deposit_amount' => 85000000,
                'currency' => 'IDR',
                'address' => 'Jl. Raya Kenjeran No. 123, Surabaya',
                'city_id' => $citySurabaya,
                'district' => 'Kenjeran',
                'sub_district' => 'Bulak',
                'postal_code' => '60127',
                'latitude' => -7.2281900,
                'longitude' => 112.7783600,
                'auction_date' => now()->addDays(30)->format('Y-m-d'),
                'auction_time' => '10:00:00',
                'deposit_deadline_date' => now()->addDays(25)->format('Y-m-d'),
                'deposit_deadline_time' => '15:00:00',
                'viewing_deadline_date' => now()->addDays(28)->format('Y-m-d'),
                'viewing_deadline_time' => '16:00:00',
                'official_auction_url' => 'https://lelangbri.com/catalog/001',
                'official_source' => 'BRI',
                'status' => 'published',
                'auction_status' => 'scheduled',
                'is_featured' => true,
                'is_hot_deal' => false,
                'views_count' => 150,
                'meta_title' => 'Lelang Rumah 2 Lantai Surabaya Timur',
                'meta_description' => 'Lelang rumah 2 lantai siap huni di Surabaya Timur dengan harga mulai 850 juta',
                'created_by' => $adminId,
                'published_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];


        foreach ($catalogs as $catalog) {
            $catalogId = DB::table('auction_catalogs')->insertGetId($catalog);

            // Insert specifications based on category
            if ($catalog['category_id'] == $categoryBangunan) {
                DB::table('asset_specifications')->insert([
                    'catalog_id' => $catalogId,
                    'land_area' => rand(100, 500),
                    'building_area' => rand(80, 300),
                    'floors' => rand(1, 3),
                    'bedrooms' => rand(2, 5),
                    'bathrooms' => rand(1, 3),
                    'parking_capacity' => rand(1, 3),
                    'electricity_power' => rand(1300, 5500),
                    'water_source' => 'PDAM',
                    'created_at' => now(),
                ]);
            } elseif ($catalog['category_id'] == $categoryTanah) {
                DB::table('asset_specifications')->insert([
                    'catalog_id' => $catalogId,
                    'land_area' => rand(200, 1000),
                    'land_length' => rand(10, 50),
                    'land_width' => rand(10, 30),
                    'created_at' => now(),
                ]);
            } elseif ($catalog['category_id'] == $categoryKendaraan) {
                DB::table('asset_specifications')->insert([
                    'catalog_id' => $catalogId,
                    'brand' => 'Toyota',
                    'model' => 'Avanza',
                    'year' => 2020,
                    'color' => 'Silver',
                    'engine_capacity' => 1300,
                    'transmission' => 'manual',
                    'mileage' => 45000,
                    'fuel_type' => 'Bensin',
                    'created_at' => now(),
                ]);
            }
        }
    }
}
