<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category; // dev by Techlink360: Import the Category model

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // dev by Techlink360: Create sample categories
        Category::create([
            'name' => 'Electronics',
            'description' => 'Gadgets and electronic devices.',
        ]);

        Category::create([
            'name' => 'Apparel',
            'description' => 'Clothing and accessories.',
        ]);

        Category::create([
            'name' => 'Books',
            'description' => 'Various genres of books.',
        ]);

        Category::create([
            'name' => 'Home & Kitchen',
            'description' => 'Appliances and decor for home and kitchen.',
        ]);

        Category::create([
            'name' => 'Sports & Outdoors',
            'description' => 'Equipment for sports and outdoor activities.',
        ]);
    }
}
