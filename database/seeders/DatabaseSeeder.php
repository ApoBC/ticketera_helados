<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product; // <-- ¡Esta línea es la clave!
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Llamar a otros seeders
        $this->call([
            UserSeeder::class,
        ]);

        // Crear productos de ejemplo
        $this->createProducts();
    }

    /**
     * Crear productos de ejemplo
     */
    private function createProducts(): void
    {
        $products = [
            [
                'name' => 'Gaseosa',
                'category' => 'bebida',
                'base_price' => 4.50,
                'is_active' => true,
            ],
            [
                'name' => 'Té helado',
                'category' => 'bebida',
                'base_price' => 5.00,
                'is_active' => true,
            ],
            [
                'name' => 'Café helado con leche',
                'category' => 'bebida',
                'base_price' => 7.50,
                'is_active' => true,
            ],
            [
                'name' => 'Helado de Vainilla',
                'category' => 'helado',
                'base_price' => 8.00,
                'is_active' => true,
            ],
            [
                'name' => 'Helado de Chocolate',
                'category' => 'helado',
                'base_price' => 8.50,
                'is_active' => true,
            ],
            [
                'name' => 'Helado de Fresa',
                'category' => 'helado',
                'base_price' => 8.00,
                'is_active' => true,
            ],
            [
                'name' => 'Brownie con Helado',
                'category' => 'postre',
                'base_price' => 12.00,
                'is_active' => true,
            ],
            [
                'name' => 'Waffle con Helado',
                'category' => 'postre',
                'base_price' => 10.00,
                'is_active' => true,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}