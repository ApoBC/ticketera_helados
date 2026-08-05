<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            ProductSeeder::class,
        ]);
        // Productos existentes...
    
    // Nuevos productos
    Product::create([
        'name' => 'Gaseosa',
        'category' => 'bebida',
        'base_price' => 4.50,
        'is_active' => true,
    ]);
    
    Product::create([
        'name' => 'Té helado',
        'category' => 'bebida',
        'base_price' => 5.00,
        'is_active' => true,
    ]);
    
    Product::create([
        'name' => 'Café helado con leche',
        'category' => 'bebida',
        'base_price' => 7.50,
        'is_active' => true,
    ]);

        
    }




}

