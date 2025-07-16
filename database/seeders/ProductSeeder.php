<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $products = [
            [
                'category_id' => 1,
                'name' => 'Smartphone XYZ',
                'description' => 'Smartphone canggih dengan kamera 48MP',
                'price' => 3500000,
                'stock_quantity' => 20,
                'min_stock_threshold' => 5
            ],
            [
                'category_id' => 1,
                'name' => 'Laptop ABC',
                'description' => 'Laptop dengan prosesor terbaru',
                'price' => 8500000,
                'stock_quantity' => 10,
                'min_stock_threshold' => 3
            ],
            [
                'category_id' => 2,
                'name' => 'Kemeja Pria',
                'description' => 'Kemeja pria bahan premium',
                'price' => 250000,
                'stock_quantity' => 50,
                'min_stock_threshold' => 10
            ],
            [
                'category_id' => 3,
                'name' => 'Jam Tangan',
                'description' => 'Jam tangan dengan baterai tahan lama',
                'price' => 750000,
                'stock_quantity' => 15,
                'min_stock_threshold' => 3
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
