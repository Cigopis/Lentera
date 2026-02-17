<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Sub Categories untuk Bangunan (category_id = 1)
        DB::table('sub_categories')->insert([
            // Bangunan
            [
                'category_id' => 1,
                'name' => 'Rumah',
                'slug' => 'rumah',
                'description' => 'Rumah tinggal',
                'is_active' => true,
                'display_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 1,
                'name' => 'Ruko',
                'slug' => 'ruko',
                'description' => 'Rumah toko',
                'is_active' => true,
                'display_order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 1,
                'name' => 'Apartemen',
                'slug' => 'apartemen',
                'description' => 'Unit apartemen',
                'is_active' => true,
                'display_order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 1,
                'name' => 'Gedung',
                'slug' => 'gedung',
                'description' => 'Gedung perkantoran atau komersial',
                'is_active' => true,
                'display_order' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 1,
                'name' => 'Pabrik',
                'slug' => 'pabrik',
                'description' => 'Bangunan pabrik atau industri',
                'is_active' => true,
                'display_order' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            // Tanah
            [
                'category_id' => 2,
                'name' => 'Tanah Kosong',
                'slug' => 'tanah-kosong',
                'description' => 'Tanah kosong siap bangun',
                'is_active' => true,
                'display_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 2,
                'name' => 'Kavling',
                'slug' => 'kavling',
                'description' => 'Tanah kavling perumahan',
                'is_active' => true,
                'display_order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 2,
                'name' => 'Tanah Komersial',
                'slug' => 'tanah-komersial',
                'description' => 'Tanah untuk keperluan komersial',
                'is_active' => true,
                'display_order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 2,
                'name' => 'Tanah Pertanian',
                'slug' => 'tanah-pertanian',
                'description' => 'Tanah untuk pertanian',
                'is_active' => true,
                'display_order' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            // Kendaraan
            [
                'category_id' => 3,
                'name' => 'Mobil',
                'slug' => 'mobil',
                'description' => 'Mobil penumpang dan niaga',
                'is_active' => true,
                'display_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 3,
                'name' => 'Motor',
                'slug' => 'motor',
                'description' => 'Sepeda motor',
                'is_active' => true,
                'display_order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 3,
                'name' => 'Truk',
                'slug' => 'truk',
                'description' => 'Kendaraan truk dan angkutan',
                'is_active' => true,
                'display_order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 3,
                'name' => 'Bus',
                'slug' => 'bus',
                'description' => 'Kendaraan bus',
                'is_active' => true,
                'display_order' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}