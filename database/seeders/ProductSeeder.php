<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            ['name' => 'Helado 1 bola', 'category' => 'helado', 'base_price' => 5.00],
            ['name' => 'Helado 2 bolas', 'category' => 'helado', 'base_price' => 8.00],
            ['name' => 'Helado 3 bolas', 'category' => 'helado', 'base_price' => 10.00],
            ['name' => 'Brownie con helado', 'category' => 'postre', 'base_price' => 12.00],
            ['name' => 'Waffle dulce', 'category' => 'postre', 'base_price' => 9.00],
            ['name' => 'Batido de frutas', 'category' => 'bebida', 'base_price' => 7.00],
            ['name' => 'Café helado', 'category' => 'bebida', 'base_price' => 6.00],
            ['name' => 'Copa de frutas', 'category' => 'postre', 'base_price' => 8.50],
            ['name' => 'Cono simple', 'category' => 'helado', 'base_price' => 3.50],
            ['name' => 'Tarta de queso', 'category' => 'postre', 'base_price' => 11.00],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }

        
    }
    // Accessor para precio formateado
    public function getFormattedPriceAttribute(): string
    {
        return 'S/ ' . number_format($this->base_price, 2);
    }
}