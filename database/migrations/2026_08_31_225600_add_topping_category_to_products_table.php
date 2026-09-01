<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE products MODIFY COLUMN category ENUM('helado', 'topping', 'postre', 'bebida', 'otro') NOT NULL");
    }

    public function down(): void
    {
        // Ojo: si hay productos con category='topping' al hacer rollback, esto fallará.
        DB::statement("ALTER TABLE products MODIFY COLUMN category ENUM('helado', 'postre', 'bebida', 'otro') NOT NULL");
    }
};
