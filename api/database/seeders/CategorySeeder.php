<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::insert([
            ['name' => 'Womens', 'category_code' => 'W', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Mens', 'category_code' => 'M', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Kids', 'category_code' => 'K', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Home Goods', 'category_code' => 'HG', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
