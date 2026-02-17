<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('cities')->insert([
            // Kota Besar
            ['name' => 'Surabaya', 'province' => 'Jawa Timur', 'is_active' => true, 'display_order' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Malang', 'province' => 'Jawa Timur', 'is_active' => true, 'display_order' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sidoarjo', 'province' => 'Jawa Timur', 'is_active' => true, 'display_order' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Gresik', 'province' => 'Jawa Timur', 'is_active' => true, 'display_order' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Pasuruan', 'province' => 'Jawa Timur', 'is_active' => true, 'display_order' => 5, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Mojokerto', 'province' => 'Jawa Timur', 'is_active' => true, 'display_order' => 6, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Kediri', 'province' => 'Jawa Timur', 'is_active' => true, 'display_order' => 7, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Blitar', 'province' => 'Jawa Timur', 'is_active' => true, 'display_order' => 8, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Probolinggo', 'province' => 'Jawa Timur', 'is_active' => true, 'display_order' => 9, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Jember', 'province' => 'Jawa Timur', 'is_active' => true, 'display_order' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Banyuwangi', 'province' => 'Jawa Timur', 'is_active' => true, 'display_order' => 11, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Madiun', 'province' => 'Jawa Timur', 'is_active' => true, 'display_order' => 12, 'created_at' => now(), 'updated_at' => now()],
            
            // Kabupaten
            ['name' => 'Kabupaten Sidoarjo', 'province' => 'Jawa Timur', 'is_active' => true, 'display_order' => 13, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Kabupaten Gresik', 'province' => 'Jawa Timur', 'is_active' => true, 'display_order' => 14, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Kabupaten Malang', 'province' => 'Jawa Timur', 'is_active' => true, 'display_order' => 15, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Kabupaten Pasuruan', 'province' => 'Jawa Timur', 'is_active' => true, 'display_order' => 16, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Kabupaten Mojokerto', 'province' => 'Jawa Timur', 'is_active' => true, 'display_order' => 17, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Kabupaten Kediri', 'province' => 'Jawa Timur', 'is_active' => true, 'display_order' => 18, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Kabupaten Jombang', 'province' => 'Jawa Timur', 'is_active' => true, 'display_order' => 19, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Kabupaten Nganjuk', 'province' => 'Jawa Timur', 'is_active' => true, 'display_order' => 20, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Kabupaten Lamongan', 'province' => 'Jawa Timur', 'is_active' => true, 'display_order' => 21, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Kabupaten Tuban', 'province' => 'Jawa Timur', 'is_active' => true, 'display_order' => 22, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Kabupaten Bojonegoro', 'province' => 'Jawa Timur', 'is_active' => true, 'display_order' => 23, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Kabupaten Ngawi', 'province' => 'Jawa Timur', 'is_active' => true, 'display_order' => 24, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Kabupaten Magetan', 'province' => 'Jawa Timur', 'is_active' => true, 'display_order' => 25, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Kabupaten Madiun', 'province' => 'Jawa Timur', 'is_active' => true, 'display_order' => 26, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Kabupaten Ponorogo', 'province' => 'Jawa Timur', 'is_active' => true, 'display_order' => 27, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Kabupaten Trenggalek', 'province' => 'Jawa Timur', 'is_active' => true, 'display_order' => 28, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Kabupaten Tulungagung', 'province' => 'Jawa Timur', 'is_active' => true, 'display_order' => 29, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Kabupaten Blitar', 'province' => 'Jawa Timur', 'is_active' => true, 'display_order' => 30, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Kabupaten Lumajang', 'province' => 'Jawa Timur', 'is_active' => true, 'display_order' => 31, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Kabupaten Jember', 'province' => 'Jawa Timur', 'is_active' => true, 'display_order' => 32, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Kabupaten Bondowoso', 'province' => 'Jawa Timur', 'is_active' => true, 'display_order' => 33, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Kabupaten Situbondo', 'province' => 'Jawa Timur', 'is_active' => true, 'display_order' => 34, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Kabupaten Banyuwangi', 'province' => 'Jawa Timur', 'is_active' => true, 'display_order' => 35, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Kabupaten Probolinggo', 'province' => 'Jawa Timur', 'is_active' => true, 'display_order' => 36, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}