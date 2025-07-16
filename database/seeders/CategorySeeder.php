<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            [
                'name' => 'Elektronik',
                'description' => 'Berbagai perangkat elektronik'
            ],
            [
                'name' => 'Pakaian',
                'description' => 'Pakaian untuk pria dan wanita'
            ],
            [
                'name' => 'Aksesoris',
                'description' => 'Berbagai jenis aksesoris'
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
