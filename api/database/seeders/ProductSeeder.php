<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = Category::take(4)->inRandomOrder()->get();

        Product::factory()
        ->count(20)->hasAttached($categories)
        ->create();

        $brands = Brand::take(4)->inRandomOrder()->get();
        
        Product::factory()
        ->count(20)->hasAttached($brands)
        ->create();
    }
}
