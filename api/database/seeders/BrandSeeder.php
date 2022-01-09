<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Brand::insert([
            ['name' => 'LC Wakiki', 'brand_code' => 'lcw', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Defacto', 'brand_code' => 'd', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Zara', 'brand_code' => 'z', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Adidas', 'brand_code' => 'ad', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
