<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            [
                'name' => 'Bangunan',
                'slug' => 'bangunan',
                'icon' => 'building',
                'description' => 'Properti berupa bangunan seperti rumah, ruko, gedung, dan lainnya',
                'is_active' => true,
                'display_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Tanah',
                'slug' => 'tanah',
                'icon' => 'land',
                'description' => 'Properti berupa tanah kosong, kavling, dan lahan',
                'is_active' => true,
                'display_order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Kendaraan',
                'slug' => 'kendaraan',
                'icon' => 'vehicle',
                'description' => 'Kendaraan bermotor seperti mobil dan motor',
                'is_active' => true,
                'display_order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}