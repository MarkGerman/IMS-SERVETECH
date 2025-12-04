<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Laptop Pro',
                'category_id' => 1,
                'brand' => 'TechBrand',
                'purchase_price' => 999.99,
                'selling_price' => 1299.99,
                'quantity' => 50,
                'reorder_level' => 10,
                'barcode' => '1234567890123',
                'description' => 'A high-performance laptop for professionals.',
            ],
            [
                'name' => 'Wireless Mouse',
                'category_id' => 2,
                'brand' => 'ConnectIt',
                'purchase_price' => 19.99,
                'selling_price' => 29.99,
                'quantity' => 200,
                'reorder_level' => 50,
                'barcode' => '2345678901234',
                'description' => 'Ergonomic wireless mouse with long battery life.',
            ],
            [
                'name' => 'Mechanical Keyboard',
                'category_id' => 2,
                'brand' => 'TypeFast',
                'purchase_price' => 79.99,
                'selling_price' => 119.99,
                'quantity' => 100,
                'reorder_level' => 25,
                'barcode' => '3456789012345',
                'description' => 'RGB mechanical keyboard with customizable keys.',
            ],
            [
                'name' => '4K Monitor',
                'category_id' => 3,
                'brand' => 'ViewSharp',
                'purchase_price' => 299.99,
                'selling_price' => 399.99,
                'quantity' => 75,
                'reorder_level' => 15,
                'barcode' => '4567890123456',
                'description' => '27-inch 4K UHD monitor with vibrant colors.',
            ],
            [
                'name' => 'USB-C Hub',
                'category_id' => 4,
                'brand' => 'PortPlus',
                'purchase_price' => 39.99,
                'selling_price' => 59.99,
                'quantity' => 150,
                'reorder_level' => 30,
                'barcode' => '5678901234567',
                'description' => '7-in-1 USB-C hub with HDMI, USB 3.0, and SD card reader.',
            ],
        ];

        // foreach ($products as $productData) {
        //     Product::create($productData);
        // }

        Product::factory(10)->create();
    }
}
